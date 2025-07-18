---
layout: post
title: MR01 WannaCry Kill Switch Report.
categories: [Tutorials, Reports]
tag: [Malware Analysis , Network Traffic Analysis] 
---

# General 

![003.jpeg](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.003.jpeg)


<a name="_page2_x33.00_y78.92"></a>**MR01: WannaCry**  

<a name="_page2_x33.00_y107.92"></a>**Executive Summary** 

**WannaCry**  is  a  ransomware  that  begins  by  checking  access  to  a  strange-looking  website: www[.]iuqerfsodp9ifjaposdfjhgosurijfaewrwergwea[.]com. This is known as its "**kill switch**" Before trying to connect to the site, the malware starts an internet session using the  **InternetOpenA** function. Then, it attempts to access the kill switch domain using **InternetOpenUrlA**. This check happens right at the start, before any damage is done. After the malware queries the URL, it checks the response to determine whether to proceed. The response from the server is evaluated based on its **HTTP status code**. If the server responds with a **status** **code 200** (indicating a successful connection), the malware checks the **Zero Flag** (ZF) in the processor. If ZF is set, the malware **exits and stops running**. This means that if the URL is reachable and responds with a **200 OK**, the ransomware stops executing. 

If the domain is **unreachable** or responds with any other status code, the malware **continues** its **execution**. The purpose of the kill switch is to add a layer of complexity to the malware’s design, making it harder for analysts to understand the code at first glance. By stopping its execution when the domain is reachable, the malware creates a way for researchers to prevent its spread in some cases. 

<a name="_page3_x33.00_y78.92"></a>**Basic Static Analysis** 

At start we can export the hash values of that sample, the original file sample can be found[ here,](https://github.com/HuskyHacks/PMAT-labs/tree/main/labs/4-1.Bossfight-wannacry.exe) as always the password is **infected**.  

**Filename**: Ransomware.wannacry.exe.malz 

**MD5**: db349b97c37d22f5ea1d1841e3c89eb4  

**SHA1**: e889544aff85ffaf8b0d0da705105dee7c97fe26  

**SHA256**: 24d004a104d4d54034dbcffc2a4b19a11f39008a575aa614ea04703480b1022c  

By checking that in Virus Total we can see that this file was analyzed 8 days ago, and this is known malware, also several vendors tagged that malware as Trojan like Avast and AVG. also several others specified that this is executable file for Win32, which means 32bit. 

![004.png](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.004.png)

![005.png](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.005.png)

The next step is to check that binary meta data values deeper, we can do that by several tools, in PEStudio we can see that this is executable file 32-bitm we can see that M Z letters as the first bytes text which tell us that this is valid **DOS/Windows executable**.  

![006.png](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.006.png)

The presence of multiple linked libraries in the executable indicates that a variety of Windows API functions are likely being used. 

On PEStudio we can see 91 flags on imports section, several Windows API function can be found here, by checking clearly, we can see that **InternetOpenA** and **InternetOpenUrlA** are involved here. 

![007.png](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.007.png)

The presence of **InternetOpenA** and **InternetOpenUrlA** functions in the imports section indicates that the malware may be interacting with the internet. **InternetOpenA** is used to initiate an internet session, while **InternetOpenUrlA** opens a URL connection. This suggests that WannaCry may be attempting to contact a remote server, likely for receiving commands or downloading additional payloads. 

This malware also utilizes more Windows Service-related APIs, such as CreateServiceA, OpenSCManagerA, and ChangeServiceConfig2A, to install itself as a persistent service, execute through the Service Control Manager, and manipulate service configurations to maintain control and evade detection. 

![008.png](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.008.png)

In addition to service-related functions, this malware also makes use of several Windows API functions that relate to **cryptographic operations**, memory allocation, and system information retrieval. Notably, the malware calls **CryptGenRandom** and **CryptAcquireContextA**, which are used to generate cryptographically secure random values and acquire cryptographic context, respectively.  

This suggests WannaCry employs encryption mechanisms—supporting its classification as ransomware. Memory management functions such as **LocalAlloc** and **LocalFree** are also present, which the malware likely uses to handle dynamic memory allocation during its runtime operations.  

Additionally, GetModuleFileNameA is used to retrieve the path of the executable, possibly for self- location or replication purposes. The combination of these API calls highlights how WannaCry interacts with system services, cryptographic libraries, and memory—revealing a structured approach to deploying its ransomware payload while remaining stealthy and self-contained. 

![009.png](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.009.png)By using floss we can check for string inside the file and may be finding some interesting value like location, URL, action or event just a string that can be using on the signature of detection rule. 

![010.png](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.010.png)

![011.png](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.011.png)

We clearly can see the URL that used by this malware, since we are using Flarevm on isolated lab, by executing that malware it will never get to that site. 

We also can search for another string by using anychars “…..” in grep, after running that I was found several what look like SMB location, so I have grep out the IP address of that location by IP. 

![012.png](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.012.png)

Also, by grep out any words that end with W give several value of windows API function that are in used in that malware, the functions identified in that malware sample (e.g., **GetModuleHandleW**, **CreateFileW**, **LoadLibraryW**, **WriteConsoleW**, **CreateFileW**, **GetStartupInfoW**, etc.) suggest that the malware is performing a range of system-level operations.  

These likely include accessing loaded modules (**GetModuleHandleW**, **LoadLibraryW**), interacting with files and possibly creating or modifying them (**CreateFileW**), writing output to the console (**WriteConsoleW**), retrieving environment variables (**GetEnvironmentStringsW**), and potentially executing additional payloads or modules. The presence of both ANSI (A) and wide (W) versions of functions implies compatibility handling. Collectively, these APIs are commonly found in malware that is setting up execution, interacting with system resources, and preparing to run its malicious logic. 

![13.png](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.013.png)Also can find the following which may be involved executable file on the process of that malware or it actually part of some process that run these executable like in cli. 

![014.png](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.014.png)

Also, by checking if there is DLL involved, several of them is what we was seen before. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.015.png)

We also can grep out if any hard drive involved and we can see the following. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.016.png)

Right now we not sure what is the full directory, but we can see that **qeriuwjhrf** that we may seen as we proceed with that analysis. 

Also I was able to find the following which tell us that **icacls** command involved and set the current directory with permission for everyone, we can’t tell so far what the current directory is, but we may find it later. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.017.png)

<a name="_page7_x33.00_y78.92"></a>**Basic Dynamic Analysis** 

By executing the file itself we can see that after some time it create file on desktop. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.018.png)

It also remove other and damage some files, as example cosmo.jpeg can’t be read anymore. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.019.png)

After several moments we can see the following on the screen and the change of the background of the desktop, which tell us that all was encrypt. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.020.png)So far, we have no idea how that program works and what the process sequence is done after execution.  

What we can do next is to revert the machine and execute that program again while some process monitor tool open on the background. 

Using System Informer we can see that after execution that program running, I have seen blinking cmd.exe start and tasksche.exe which look like related to that malware since we have seen these on the basic static analysis step. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.021.png)

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.022.png)

Using a process monitor we can see that this WannaCry has done several actions on the local box. We can see creation of files 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.023.png)

If we filter out the network activity we can see that this malware start several TCP connections on local network, which looks like he have some ability of worm, 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.024.png)

We also can see several thread that was created and image load for several dll. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.025.png)

So next we can run Procexp, in my case I have ran CMD as administrator. ![ref1]

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.027.png)

After several moments we can see that this program start subprocess of tasksche.exe 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.028.png)

If we start TCPview we can see that this malware try to riche out to another address on 445 which is SMB. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.029.png)

The sessions is ending since that box has no internet connection. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.030.png)

` `And again the PC was encrypt, so we need to start over, this time, since we know that this program trying to reach out to the internet we will used REMnux with inetsim open for allow such fake session.  

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.031.png)

This time running wireshark as administrator and running the malware on background will the INETSIM is open and running. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.032.png)

In that case the INetSim implement fake DNS and fake several services like HTTP, FTP and so on, so now after we will start the malware we should see some session to some target (ip based) or some DNS query, just remember that we have seen on basic analysis phase the weird URL which may be used in that case. 

After clicking the malware and run it as admin, we can see on wireshark the DNS query to the same domain we have saw in the basic static analysis phase, also REMnux replay with it’s wone address. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.033.png)

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.034.png)

Right after that DNS query we can see session start on HTTP for that domain, which is also fake answers by INetSim, so the session start successfully. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.035.png)

I was thinking that this may be some step to get another payload to download, but appear that after that session wannacry not encrypt the desktop, which sound odd, but that is the deal, so we can try that once again but without INetSim to see what happening if there is no session to that weird domain. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.036.png)

After close off INetSim, and run again the malware I was able to see TCP RST regarding that the HTTP service are down, please note that this time we have deal with DNS since it was save on the cache, this is why the TCP session to that domain start right away without DNS query. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.037.png)

Then we can see the junk for that process, like the IPC on the gateway which look like the worm functioning and then it successfully encrypts the desktop. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.038.png)

We can also see that he is trying to get another machine on the same network share. I have also setup new virtual machine (windows 7 ultimate in that case) and connected it to the shared network with Flarevm, then I was able to see the following after filtering out port 445 and SMB. 

We can see that the malware tried to do something with IPC$ of that 10.0.0.15 machine, in that case it end up with error, if we are looking further on the session, we can see that the malware also tried with another address. We can’t tell from that operation what the malware trying to do by getting to that IPC$, but we can guess that this is the functioning of lateral movement to another hosts on the same network, in my case it just failed and we can’t tell why so far. 

**3011  133.101206  10.0.0.4  10.0.0.15  SMB  125  Tree Connect AndX Request, Path: \\10.0.0.15\IPC$ ![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.039.png)**

**3012  133.101234  10.0.0.15  10.0.0.4  SMB  93  Tree Connect AndX Response, Error: Non specific error code 3013  133.101421  10.0.0.4  10.0.0.15  SMB Pipe  132  PeekNamedPipe Request, FID: 0x0000** 

**3014  133.101447  10.0.0.15  10.0.0.4  SMB  93  Trans Response, Error: TID invalid**

**3164  136.113486  10.0.0.4  10.0.0.15  SMB  191  Negotiate Protocol Request**

**3165  136.113593  10.0.0.15  10.0.0.4  SMB  169  Negotiate Protocol Response**

**3166  136.114052  10.0.0.4  10.0.0.15  SMB  194  Session Setup AndX Request, User: anonymous**

**3167  136.114130  10.0.0.15  10.0.0.4  SMB  259  Session Setup AndX Response** 

**3168  136.114526  10.0.0.4  10.0.0.15  SMB  150  Tree Connect AndX Request, Path: \\192.168.56.20\IPC$** 

**3169  136.114614  10.0.0.15  10.0.0.4  SMB  114  Tree Connect AndX Response** 

**3170  136.114987  10.0.0.4  10.0.0.15  SMB  136  Trans2 Request, SESSION\_SETUP** 

**3171  136.115089  10.0.0.15  10.0.0.4  SMB  93  Trans2 Response, SESSION\_SETUP, Error: STATUS\_NOT\_IMPLEMENTED** 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.040.png)

Also, several broadcast ARP query was sent by that malware, we can assume that this function is for find another hosts on the same shared network. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.041.png)

During that session you can see that my desktop was encrypted so reverting again is needed. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.042.png)

By viewing this all functioning , this led us to think that this WannaCry trying to get the domain www[.]iuqerfsodp9ifjaposdfjhgosurijfaewrwergwea[.]com, if it successfully gets replay from that domain the function of this malware are stopped, but if not it will run and encrypt any file in the desktop. 

So now we have map the functions and action that occur during execution of that malware, we can now go to advance static analysis and see if what we have found correlate to that in the assembly level, and if so what is the functions and actions that done in case that this malware can’t get to that suspected site. 

<a name="_page14_x33.00_y78.92"></a>**Advance Static Analysis** 

Now it’s time to used several disassembler program to do some advance static analysis and to check if we have corrected so far with what we have seen and find more information related to the malware process after it failed to get successful reponed from the weird site. 

After load the malware itself to cutter, what I like to do is to view that in graph mode, this can tell us the link between the action and the order of decision and what they based on. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.043.png)

We can see here the main function, if we look closely we can see the push of WSI and EDI to the stuck, we can’t tell why this actions needed so far, but we can find the first indication we have found earlier and I talking about the full URL to the weird site, we can see that this URL moved inside ESI, so we can guess that this register will be used later for load threat process to that URL. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.044.png)

After that we can see the **xor** operation which compares the value inside EAX to itself, which mean in the end that the EAX value is 0. Then the **rep** operation in used, which mean repeat the following action, the action itself is **movsd** which is used to move a double word (32 bits / 4 bytes) from ESI to EDI, so it mean that the ESI contain the URL we have saw and this URL copy or move to EDI register bytes after bytes, the **rep** as said are used for repeat this instruction **ECX** times. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.045.png)

After the rep we can see another **movsb**, which moves a **single byte** from ESI to EDI, likely null byte for end up the moving value of the URL. ![ref1]

Then we can see several values that used for move values from register EAX to some memory location, since it’s look like the value of EAX is 0, this may mean that the location of var\_17h and var\_13h etc, are get the value of 0. 

mov      dword [var\_17h], eax 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.046.png)

Then we can see the **push** operation that push the EAX register to the stuck, we know so far that this EAX value is 0, and in that case the first value that push in the stuck is 0 then 0 then 0 then 1 then another 0, then we can see **mov** operation that move the value of AL to some location in memory, then the **call** of function is running, in that case InternetOpenA which is windows API function. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.047.png)

If we check the function is windows site, we can see that this function used for initializing an internet session in applications that access online resources. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.048.png)

We can see that it’s get 5 values, by windows site, we can see that function can be found in wininet.dll. this may mean that threat process start for some session. 

Then we can see another push to the stack operation, we also can see **lea** operation in used, in that case it just copy the address of location [var\_64h] to ECX register, then the EAX register value used for move into ESI, which may mean that ESI contain 0, then ECX push to the stuck and ESI. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.049.png)Then we can clearly see that another **call** function are in used, if we check on Microsoft site we can see that this API cuntion used to get the URL value on the second argument, which indication of ECX in our case must contain the URL value, which mean that var\_64h address value may point to the location in memory where the URL are stored. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.050.png)

Then we can see that the EAX move back to EDI, since that line came only after the call of InternetOpenUrlA, it mean that now EAX should contain the value that responed from the action of that call line, in other words, it looks like if the query to the web address success, mean there is respoded from that query, then the value are stored inside EAX and it moved to EDI register right after. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.051.png)

In case there is no responding, this is mean that the EAX value will be 0, then the ESI is pushed to the stuck, the InternetCloseHandle moved inside the ESI register, which mean that this register going to be used later to close the internet session, and then some test are done. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.052.png)

In that test there is checking for EDI, so if the EDI contains some value which is not 0, then the ZF (Zero Flag) is equal to 0, if the EDA is 1, then in the end of that test the ZF will be equal to 1, then the jne is in used, this jne (Jump if Not Equal) used for jump to another location if the ZF is not equal to 1, so the logic here is as follows: 

1. If there is some value inside the **EDI**, then: 
   1. The **test** made the ZF to be **0**, then **jne** used to check that ZF and since it is **0** then this **jne** used for jump to the location address of **0x4081bc**. 
1. If there is no value inside the **EDI**, then: 

   -  The **test** made the ZF to be **1**, then **jne** used to check that ZF and since it is **1** then this 

**jne** is **not** used, so the **instruction** **continues** **normally** without jumping to other location. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.053.png)If we click in **cutter** on the tab of **decompiler** we will be able to see that logic as well. Here we can see that the responding of InternetOpenUrlA saved back to EAX, the EAX value save in EDI, then the EDI is checking if it equal to 0, and if so some function (fcn\_00408090) are used here, but if EDI is not equal to 0 which mean there is an respond from the URL, then it just end up the function of that malware, exactly as we have seen on the basic dynamic analysis process.  

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.054.png)

Checking the fcn\_00408090 function, lead me to another graph in cutter which is likely the encryption process itself 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.055.png)

First, we can see that this function get several variables as start, then we can see the line of **sub esp, 0x10**, which subtract the stack by 16 bit, then several values push to the stack and call for **GetModuleFileNameA** are made and another **call** for **\_\_p\_\_argc**. That value came from MSVCRT.dll which is in use in that case. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.056.png)

Then we can see compare of two value with **cmp** command which check 2 against EAX register, then if the value of EAX are grater then 2 it will jump to location 0x4080b9. 

If we tring to read the decompile section on cutter for that part, we can see the following GetModuleFileNameA in used, and we can see that it get three arguments. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.057.png)

By reading the functioning of that Windows API, we can see that this part used retrieves the fully qualified path for the file that contains the specified module.  

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.058.png)

So, argument two should contain the full path to the file, and the file should be the executable malware itself, we can guess that the malware wants to know it’s location on the local disk. 

So this part after the kill switch lead the functioning of that malware, it may check several parameters like fining it’s location, if we going to the string section we can see more several function that used to load data from the local victim and find any information that may influence the reaction of the malware. In that example we can see the GetNativeSystemInfo that used for load information about the current system to an application running under[ WOW64.](https://learn.microsoft.com/en-us/windows/desktop/WinProg64/running-32-bit-applications) 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.059.png)

<a name="_page18_x33.00_y564.92"></a>**Advance Dynamic Analysis** 

So, far we know the way that WannaCry malware works, it’s try to get to some remote website, and if there is positive response the malware function not running and the program is close, but if not then the malware is running and encrypt the file on the current directory. 

What we can do next is to test that kill switch on the debugging and see it’s functioning by execute the malware. In my case I am going to use x32dbg debbuger. 

After opening that debbuger and attach the malware we can press F9 for step to the main function. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.060.png)

What we want to do is to find the location of the kill switch, since we know the full URL that are in use, we can search for such string and setup breakpoint that used for pausing the program. ![ref1]

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.061.png)

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.062.png)

Setting breakpoint can be done by press F2 or pressing the breakpoint button. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.063.png)

After that was done we can press F9 again to jump into that breakpoint. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.064.png)

Also by checking the registers we can see that ZF is not yet set, we just need to remember that if this zero flag are set which mean there is an response related to the query for that URL then the function of the all malware should be stop, what we can do is to execute INetSim on REMnux and going step by step on the debugger. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.065.png)

Then after we get to the point of rep movsd, which used to move single byte as we saw on the basic static analysis. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.066.png)

Then we can get to the point that the InternetOpenA API are used for the session that the malware try to do for that URL. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.067.png)We also can find the InternetOpenUrlA that used for query to that URL as we saw on the advance static analysis. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.068.png)

So now we going to the test part that test the ZF. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.069.png)

If we check the registers again we can see that the ZF is now set. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.070.png)

Then if we going steps to the rest of the program we can see that we have jump to the path that end the functioning of that malware. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.071.png)

On Wireshark we can see the query to that URL. 

![](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.072.png)

And the program is end up as expected, but if we stop INetSim on REMnux, the operation will go to encrypt the local windows as expected like we saw on the advance static analysis part. 

<a name="_page21_x33.00_y78.92"></a>**Indicators of Compromise (IOC’s table)** 

From what we have found so far we have several indication for detect that malware, so I came up with the following table, please not that the main function that was used for detect the malware is the kill switch, I guess that digging deeper allow us to find more information about the encryption itself. 



|**Indicator Type** |**Value** |
| - | - |
|Filename |Ransomware.wannacry.exe |
|MD5 |db349b97c37d22f5ea1d1841e3c89eb4 |
|SHA1 |e889544aff85ffaf8b0d0da705105dee7c97fe26 |
|SHA256 |24d004a104d4d54034dbcffc2a4b19a11f39008a575aa614ea04703480b1022c |
|IP Address |192\.168.56.20 |
|String |Qeriuwjhrf |
|String |Please\_Read\_Me@.txt |
|Executable |icacls . /grant Everyone:F /T /C /Q |
|Executable |mssecsvc.exe |
|Executable |tasksche.exe |
|Executable |cmd.exe /c |
|URL |www.iuqerfsodp9ifjaposdfjhgosurijfaewrwergwea.com |

<a name="_page22_x33.00_y78.92"></a>**Detection Rules & Signatures** 

So now we could make some YARA rule for detect that IOC’s, since we have several indicators we can used them together. 

This YARA rule, called WannaCry\_Correlated\_IOCs, is built to help find the WannaCry ransomware by looking for several known signs of the malware. These signs (called IOCs) are split into five groups: file names, special strings inside the malware, commands it runs, extra programs it uses, and the well-known kill switch website. By checking for different types of signs together, the rule makes it easier to spot WannaCry and avoid false alarms. 

The condition says the rule will match if it finds at least one sign from each group (except the file name, where it can match that or a string inside the file). That means it needs to find one string inside the file, one command, one extra program, and the kill switch website to trigger. This makes sure the rule only matches files that really act like WannaCry, not just files that have one or two random things in common. 
![073.png](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.073.png)
