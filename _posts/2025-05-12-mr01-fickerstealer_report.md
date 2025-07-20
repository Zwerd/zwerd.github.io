---
layout: post
title: MR02 FickerStealer Malware Report.
categories: [Tutorials, Reports]
tag: [Malware Analysis , Network Traffic Analysis] 
---

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.003.jpeg)

**MR02: FickerStealer**   

**Executive Summary** 

The analyzed sample of the **FickerStealer** malware exhibits preliminary reconnaissance behavior without  progressing  to  full-scale  data  theft.  Upon  execution,  the  malware  performs  basic environment  enumeration,  such  as  retrieving  the  system  locale  and  querying  **api.ipify.org**  to determine the machine's external IP address. This IP is saved to a file named **datasss.png** in the **C:\ProgramData\** directory. Shortly afterward, the malware attempts to establish a connection to its command-and-control  (C2)  server  at  **fatfarts.com**,  indicating  preparation  for  potential  data exfiltration. However, the network interaction does not include any outbound transfer of sensitive data. 

No evidence was found of deeper data harvesting activity. Specifically, the malware does not access known data storage locations such as browser credential databases (Login Data), password vaults (e.g., KeePass), or cryptocurrency wallets. Furthermore, it does not invoke decryption APIs like CryptUnprotectData or engage with SQLite databases, both of which are typically associated with information theft. These findings suggest that the malware either relies on a remote configuration (which was not provided in this environment), or employs conditional logic to avoid executing its payload in sandboxed or offline conditions. As such, this sample demonstrates only its initial stages, and further behavioral analysis may be required in a fully connected environment to observe its complete functionality. 

**High-Level Technical Summary (with diagram)** 

The analyzed FickerStealer sample demonstrates initial reconnaissance and network activity but does not proceed to steal or exfiltrate sensitive information. The following key actions were observed during execution: 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.004.png)

1. **Mutex Creation**: The malware creates a uniquely named mutex ("ktykftykftyktfyk") to prevent multiple instances from running simultaneously. 
1. **Environment Enumeration**: It collects basic system information, including locale settings and process/thread identifiers. 
1. **External  IP  Acquisition**:  The  malware  loads  Urlmon.dll  and  uses  the **URLDownloadToFileA** API to contact **api.ipify.org**. The response (external IP address) is saved to a file named datasss.png in **C:\ProgramData**. 
1. **File Handling**: It reopens and reads **datasss.png**, presumably to verify or prepare it for further use. 
1. **Command-and-Control Communication**: A DNS resolution and socket connection are initiated toward fatfarts.com. The malware establishes a TCP connection and waits for a response. 

No Further Malicious Activity Observed: No file system access to browser credentials, password vaults,  or  crypto  wallets  was  detected.  No  calls  to  sensitive  Windows  APIs  such  as CryptUnprotectData or sqlite3\_open were made. No data exfiltration or module activation occurred following the C2 connection. 

**Basic Static Analysis** 

By checking that malware hash on viruses total to check and get more information about that sample as a first stage. 

**Filename**: SecuriteInfo.com.Trojan.Packed2.42600.30573.20195.exe 

**MD5**: 9ada122303e6dee1c0f0171bf2e59253  

**SHA1**: b9f2cac95510c1199083504e0ae57fd14bf559d5 

**SHA256**: b3cfbb058c0ecbd7da7f5bdd740fa729f7b0d9cf61f93b32750ce06745abc24c 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.005.png)

We can see that the file name on viruses total in that case is 122.exe and it have tagged as malicious file by 58 vendors out of 73, and they specified this one as Trojan. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.006.png)

Then using floss for extract string from the file itself to local txt file for allow us find related information that can give us clue on that basic static analysis be fore we go further. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.007.png)

Then we can grep out DLL files that look like being used by that malware. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.008.png)

In that case we can see several important DLL imports were discovered, indicating the functionality and behavior of the malware. 

By reading about each one on the google we can find more interesting information about the function abilities of each, so that give us clue about the functioning of that malware and what it do, but we can tell so far, the order of the functions. 

**Urlmon.dll** – Suggests use of HTTP functionality, likely for downloading additional payloads or communicating with a Command and Control (C2) server. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.009.png)

**KERNEL32.dll** – Provides core Windows API functions such as memory allocation, process and thread manipulation, and file I/O. It is commonly used in all Windows executables. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.010.png)

**msvcrt.dll**  –  Indicates  use  of  C  runtime  functions,  possibly  for  memory  operations,  string manipulation, or system calls. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.011.png)

**WS2\_32.dll** – The presence of this library shows that the malware uses Winsock for low-level TCP/IP networking. This implies active communication with remote servers, potentially for data exfiltration. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.012.png)

**ADVAPI32.dll**  –  Typically  used  for  registry  access,  privilege  manipulation,  or  cryptographic functions. Its use might indicate persistence mechanisms or access to sensitive system information. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.013.png)

**CRYPT32.dll**  –  Supports  encryption  and  decryption,  possibly  to  encode  stolen  data  before transmission to evade detection. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.014.png)

**GDI32.dll** – Used for graphics and screen rendering. Its presence suggests the malware might perform screen captures. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.015.png)

**USER32.dll**  –  Provides  functions  for  interacting  with  the  user  interface,  potentially  indicating keylogging or window enumeration. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.016.png)

**NTDLL.dll** – Gives access to low-level NT system calls. Malware often uses this for stealthy operations, such as manual mapping or avoiding detection by user-mode security tools. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.017.png)

At this stage, the presence of these DLL imports suggests that the malware may rely on various system capabilities. Specifically, the inclusion of WS2\_32.dll and Urlmon.dll indicates potential network communication functionality, while the use of GDI32.dll hints at possible interaction with graphical components, such as screen rendering — which may support screenshot capabilities. Other libraries, such as ADVAPI32.dll, USER32.dll, and CRYPT32.dll, suggest broader system interaction including registry access, user interface manipulation, and possible data encryption. However, while these imports reveal potential areas of functionality, they do not confirm any specific malicious behavior. 

Also, by searching for windows API, let’s say these that end up with W we can find the following. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.018.png)

The extracted wide-character API calls strongly indicate that the malware performs host profiling (e.g.,  **GetComputerNameW**, **GetLocaleInfoW**), registry interaction, file system traversal (e.g., **FindFirstFileW**), and network socket creation (**WSASocketW**). These functions suggest that the malware likely gathers system information, searches for files of interest, and communicates with a remote  server.  However,  while  the  presence  of  these  functions  implies  certain  behaviors, confirmation requires dynamic execution and code flow analysis. 

By searching the work password we can see the following, which may be some variable that used on the functioning of that executable file. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.019.png)

We also can search for protocols used, like http and ftp, in the following case, I have found several URL, several seems valid and may be used during the malware execution, we may get to know about them on the other part of the assessment like the dynamic analysis part. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.020.png)

We can see here four URL’s that repeating them selfs: http://ocsp.digicert.com 

http://crl.sectigo.com 

http://crt.usertrust.com 

https://sectigo.com/CPS 

These URLs are not C2 indicators or signs of malicious communication. They are most likely: 

- Embedded in the digital signature of the malware (even if it's invalid or expired), or 
- Part of the OS validating certificate chains when the binary is loaded. 

By searching other files that can be execute on windows as part of website, I have found the following. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.021.png)

One potential indicator of malicious intent was found: 

- Email  address:  **tramplink-msk@rambler.ru**.  This  could  be  used  for  attacker identification, exfiltration, or embedded metadata. 

The following is just way of extracting the domains and subdomain and order what we have found so far. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.022.png)

By using PEview we can see the magic starting value for executable file which is 4D 5A the MA sign, the we can see on the other headers 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.023.png)

We also have indication that this malware file used for 32bit system architecture. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.024.png)

On PEStudio we can see the same indication for 32bit malware. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.025.png)

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.026.png)

PEStudio also can suggest what each DLL is used for. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.027.png)

This tool gives us the following indication of another windows API’s that being used and also suggest the technique that this malware may do during execution. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.028.png)

Each **X** in the "**Flag**" column next to an imported function indicates that this particular API is: 

- Known to be **commonly used by malware** 
- Possibly **risky or suspicious** in a behavioral context 
- Flagged by PEStudio’s internal ruleset based on **threat intelligence and heuristics** 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.029.png)

The presence of the string Mingw-w64 runtime failure: in the .rdata section suggests that the malware was compiled using the MinGW-w64 toolchain. This compiler is **commonly used in Linux environments for cross-compiling** Windows executables. While this does not confirm the development platform, it increases the likelihood that the malware was built on a non-Windows system, such as Linux.  

So, if Mingw-w64 have being used for compile that file, is an indication that the source code may be **C**/**C++** and not **.NET**, we can also check die tool that can give us more indication what is used for that malware. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.030.png)

So, we can be sure that this malware was written in C and was compiled with MinGW. 

**Basic Dynamic Analysis** 

I have ran that malware under CMD that run as administrator, then with several tools check it’s activities, on the procexp I was able to see the following which tell us that this malware indeed have being run from cmd process. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.031.png)

Also, on System Informer we can see the same 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.032.png)

On Procmon I was able to see that this file sample do several stuff related to registry and directory 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.033.png)

We can see the following DLL files in used related to that sample 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.034.png)

Also by scrolling down, I was able to see that it create some TCP session to my REMnux box, so I was open Wireshark on background to see what it doing. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.035.png)

The by follow the steam I have found the following HTTP GET query, I had another query but they all was to some Microsoft location, so I get this is some issue with my LAB. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.036.png)

Following the all stream lead us to the following information. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.037.png)

Since that domain have not been found on the basic stage then I have search for DNS query about that api.ipify.org and found that this was done after I have ran System Informer, so I have filer out all DNS query and then I have found one of the domain we have seen earlier fatfarts.com. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.038.png)

The checking the order if self, found that after this DNS query some HTTP session was startup. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.039.png)

Follow that stream didn’t give much, I can’t be sure that this steam related to that domain but if yes, it was end right away. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.040.png)

Filter out the information from Procmon again about the TCP session we can see the process ID and the source port which is 50267, so this indication I am not on the right session. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.041.png)

This information lead us back to the briviuse session we have found 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.042.png)

Then  on  Procmon  I  have  also  found  the  following  which  means  that  the  GET  query  to  the /?format=xml, was the first query, then the second query was to api.ipify.org, then the second was to fatfarts.com. 

After search on google, I have found that api.ipify.org is a legitimate public IP lookup service often used by malware to determine the external IP address of the infected machine. This information can help attackers identify the victim's geolocation or check if the system is running in a sandbox or virtual environment. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.043.png)

Based on the observed behavior, this sample attempts to connect to api.ipify.org and retrieve an XML file via the endpoint /?format=xml, likely to determine the public IP address of the infected host. Following this, it initiates a request to fatfarts.com, which is suspected of serving as a command- and-control (C2) domain.  

However, the HTTP session to fatfarts.com does not proceed as expected, suggesting either a failed connection, server-side filtering, or a conditional communication trigger not met during this run. 

Since that sample ask for api.ipify.org, we know that it searches for the IP address of the victim, I have set up webserver that contains record of that domain for 10.0.0.1 and that web always return with 200 OK that contain 10.0.0.4. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.044.png)

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.045.png)

But still the behavior is the same, the session ends after trying to get fatfarts.com domain. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.046.png)

But please note the time. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.047.png)

If we change the time format, we can see that this is 2 seconds. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.048.png)

This behavior is typical of any TCP-based application that fails to receive a reply it cleans up the socket to avoid hanging the process. 

By searching for another information related to the action of that sample using Procmon, I have found that it left surprise. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.049.png)

Checking the directory, I have found that this file was created on the local system. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.050.png)

So far, the dynamic analysis reveals that the **FickerStealer** sample performs environment profiling by retrieving the **victim's public IP address** using the legitimate service **api.ipify.org**, followed by an attempted connection to a suspicious domain (**fatfarts.com**), which may serve as a Command- and-Control (C2) server.  

Although the malware didn’t manage to connect to its command-and-control (C2) server - possibly because of a sandbox, offline server, or missing conditions - it still showed other activity like accessing the registry and file system. It also created an image file on the local machine. This behavior suggests the malware tries to collect data, may attempt to stay on the system, and is built to talk to an external server. 

**Advance Static Analysis** 

Opening that executable with Cutter leads us to the following main. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.051.png)

We can see here specifications about variables, then after it down several stuff like checking the values and variables we can see the first call of function named **fcn.00433440**, then we can see another changing that done but right after another call to function named **fcn.00415270**. 

The start of the fcn.00433440 looks like it insert value (likely 0 or 1) to **eax** and then test it for getting the ZERO FLAG (**ZF**), if the flag are 0 it jump to the location of **ret** meaning program close. 

But if the ZF is 1 it will proceed the process, we can see another several operation that move values inside the block ofcode, I can’t tell exectly what they do but I guess that this operation is part of restart the envirument of the main code. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.052.png)

If we look further down, we can see two more function calls. The first one performs some operations and then jumps to another location in the code. The second call leads to a function that doesn't seem to connect to anything recognizable from the basic static or dynamic analysis — in other words, it doesn't reference any strings, APIs, or behaviors we've already observed.

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.053.png)

At this stage, we can return to the main function and follow the second function call, which is more likely to contain relevant information about the malware’s behavior and actual functionality. By doing so, we can see that this function gets many arguments, so we need to scroll down to find interesting information. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.054.png)

` `At first we can see that function call, by looking inside of that we found same, nothing interesting that are reference to the static analysis we have done erliear. 

But then we can see the following Windows API call, it is not so interesting but still that is the first time we see some value that can be found and reference on the static stage we have done so far. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.055.png)

At this point, we observe that the malware pushes the value of the EBX register as an argument to **LoadLibraryA**. This indicates that EBX likely contains a pointer to a string representing the name of a DLL. 

By scrolling through we can see another Windows API’s like GetProcAddress, GetUserDefaultLocaleName, GetSystemMetrics, 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.056.png)

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.057.png)

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.058.png)

So far we can’t find the location of the function that responsible the action of HTTP query to api.ipify.org, and even not the http GET query to fatfart.com, also if we search on string in cutter we can’t see them at all, which may tell us that fatfart as example exist on some other function. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.059.png)

What we can do on that case is to use another tool for decompile the code, cutter can do that also but from time to time it just stuck on the following error, this is why I have used ghidra. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.060.png)

In ghidra, after create new project and import the binary file of FickerSteaer, we can see the following window that show the assembler code and the decompiles code. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.061.png)

We can see the entry point which is the main function that contain two function, the first we have saw on cutter that responsible for reset stuff related to that malware while the second one in the interesting coder block. 

After step into the function FUN00401150(); we can see another block of code which we have seen on cutter. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.062.png)

By digging down deeply I was able to find another function called “call fickerstealer.4343D0”. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.063.png)

And that one was contain FUN\_00415270 which have really long block code. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.064.png)

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.065.png)

By scrolling  down we can see several function that look like used for information container 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.066.png)

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.067.png)

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.068.png)

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.069.png)

but part of that at the end contains the following windows API: 

GetProcessHeap GetSystemMetrics GetDC GetCurrentObject GetObjectW CreateCompatibleDC CreateDIBSection BitBlt  

From that all, we can assume that the malware captures a screenshot of the victim’s desktop by creating a compatible memory device context, copying the screen content into it, and storing it in memory using a DIB (Device Independent Bitmap) section. This is done through standard Windows API calls like GetDC, CreateCompatibleDC, CreateDIBSection, and BitBlt, allowing the malware to grab an image of the current screen, likely for later exfiltration. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.070.png)

**Advance Dynamic Analysis** 

In that step we can run debugger and see the point where the query about the domain farfart or even the API call was done, in my case I am using x32dbe, the malware start at JMP point, so we go through the flow while Wireshark are open on the background. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.071.png)

Then after several tests, we can see the following on wireshark appear, so we know the point we land that made that call. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.072.png)

On the debugger we can clearly can see that the following function are the call who made that query in DNS. 

call fickerstealer.4343D0 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.073.png)

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.074.png)

We can see that this is the same point we have found on Ghidra. Then after digging more I was able to find the following function call of urlmon, by execute it, new DNS query for ipify.org is made, so this may be the point of interesting. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.075.png)

Then by stepping into that call found another call that by execute it the DNS query are made, so I have set another breakpoint on that one, right after I haver found more location of point that need to be looking at. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.076.png)

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.077.png)

Then I was able to see loop that I think made by **NtUserMsgWaitForMultipleObjectsEx**, the query to the domain we have seen (api.ipify.org) done while that call are made. After reading more about that function, I have found that this function does **not directly perform network communication**, but serves as a **blocking mechanism that waits for multiple event handles** or **Windows messages**. Notably, immediately after this call, a DNS request for api.ipify.org was captured in Wireshark. This suggests that the function is being used to wait for the completion of a background thread or asynchronous event - most likely a network-related operation such as a DNS resolution or an HTTP request. So, it’s likely that use of MsgWaitForMultipleObjectsEx in this context indicates that the malware is structured around a multithreaded or event-driven architecture, where synchronization is handled via system-level wait functions to obscure the flow of execution. 

Also by going the loop step by step found in the CPU window the following letters. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.078.png) ![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.079.png) ![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.080.png) ![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.081.png)

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.082.png) ![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.083.png) ![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.084.png) ![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.085.png)

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.086.png) ![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.087.png) ![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.088.png) ![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.089.png)

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.090.png) ![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.091.png) ![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.092.png) ![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.093.png)

We can clearly see that not all the characters are letters, there are special ones, and also non- Latin letters. 

In this case, the string observed ($o<HT\lx “’AIQaq`) appears to be obfuscated or XOR-encoded data, rather than a standard encoding format like Base64. Its use of special characters, non- alphabetic symbols, and non-Latin characters strongly suggests the presence of a custom encoding or encryption scheme. 

Additionally, by examining the current assembly code in the debugger, several Windows API functions were identified in use, including **TranslateMessage**, **DispatchMessageW**, and **PostQuitMessage**. These functions are part of the standard Windows message loop used in GUI applications, allowing the program to process window messages and events. Their presence suggests that the malware either maintains a graphical user interface component or emulates a message-driven structure to manage its execution flow or deceive analysis tools. This approach can also serve to delay or obscure malicious activity, especially when combined with waiting functions like MsgWaitForMultipleObjectsEx. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.094.png)At that point, I realized that continuing with a traditional debugger was becoming inefficient due to the complexity of the control flow and the frequent use of Windows message loop APIs. As a result, I decided to switch to **API Monitor**, a specialized tool that allows real-time monitoring of Windows API calls along with their parameters and return values. This tool can help to observe the malware’s behavior more effectively, particularly its use of networking and system APIs, without being obstructed by the obfuscated execution flow. 

After play with that found the API that create directory on the summary monitor. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.095.png)

Then I was able to find that it try to create png file named datasss.png, and even trying to download the external IP address from api.ipigy.org and save it on that datasss.png file. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.096.png)

I also notive that he trying to read something from my local cache. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.097.png)

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.098.png)

The malware sample uses the **CreateMutexA** API call to create one or more uniquely named mutex objects (e.g., "ktykftykftyktfyk"). This technique is commonly employed by malware to ensure that only a single instance of the malware runs at any given time.  

After attempting to create the mutex, the malware may call GetLastError to check whether the mutex already exists. If the error code ERROR\_ALREADY\_EXISTS is returned, the malware can assume it is already running and terminate itself to avoid redundant execution.  

This behavior is a form of self-regulation and can also serve as a basic anti-analysis or anti-sandbox mechanism. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.099.png)

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.100.png)

Then clearly can see the way for interation with fatfarts.com that start by getting the address information of that domain. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.101.png)

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.102.png)

By trying to read that datasss.png, I was able to see that it contain the default page of inetsim. 

![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.103.png)

Based on the observed behavior, the analyzed FickerStealer sample performs only **initial setup actions** and does not appear to reach the stage of **collecting sensitive information** from the system. The malware loads necessary libraries, gathers basic environment data (such as the system locale), and makes an HTTP request to **api.ipify.org to obtain the external IP address**, which is **saved to a file named datasss.png**. It then initiates a connection to the command-and- control (C2) server at **fatfarts.com**. However, there is no evidence of attempts to access files containing credentials (such as browser Login Data, password vaults, or cryptocurrency wallets), nor any calls to system functions like CryptUnprotectData or sqlite3\_open. These findings suggest that the information-stealing phase is not triggered in this execution, potentially due to a missing response from the C2 server or reliance on external configuration data to activate the data exfiltration logic. 

**Indicators of Compromise (IOC’s table)** 

From what we have found so far we have several indication for detect that malware, so I came up with the following table. 



|**Indicator Type** |**Value** |
| - | - |
|**Filename** |SecuriteInfo.com.Trojan.Packed2.42600.30573.20195.exe |
|**MD5** |9ada122303e6dee1c0f0171bf2e59253 |
|**SHA1** |b9f2cac95510c1199083504e0ae57fd14bf559d5 |
|**SHA256** |b3cfbb058c0ecbd7da7f5bdd740fa729f7b0d9cf61f93b32750ce06745abc24c |
|**Mutex** |ktykftykftyktfyk |
|**File (Created)** |C:\ProgramData\datasss.png |
|**Domain (C2)** |fatfarts.com |
|**Domain (IP lookup)** |api.ipify.org |
|**File Accessed** |C:\ProgramData\datasss.png |

**Detection Rules & Signatures** 

So now we could make some YARA rule for detect that IOC’s, since we have several indicators, we can used them together. 

**rule FickerStealer\_Generic![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.104.png)**

**{** 

**meta:** 

**description = "Detects FickerStealer sample based on mutex, filename, and known indicators" author = "Zw3rd"** 

**hash\_sha256 = "b3cfbb058c0ecbd7da7f5bdd740fa729f7b0d9cf61f93b32750ce06745abc24c" malware\_family = "FickerStealer"**

**date = "2025-06-08"** 

**strings:** 

**$mutex = "ktykftykftyktfyk" $domain1 = "fatfarts.com" $domain2 = "api.ipify.org" $filename = "datasss.png"**

**condition:** 

**uint32(0) == 0x5A4D and** 

**(all of ($mutex, $domain1, $domain2, $filename))**

**}** 
`  `24![](/assets/images/malware-analysis/Aspose.Words.2a7e8871-0ebc-4845-970e-0c16a027bac6.105.png)
