---
layout: post
title: LPIC2 Certification Journey
excerpt: "Today morning I received a message from LPI that my certificate will expire in 9 months and so it is time to start studying for the second Linux certification, this will advance me to the third Linux information security certification that will include what I am looking for, this certification is split in two"
tags:
- Linux

---

Today morning I received a message from LPI that my certificate will expire in 9 months and so it is time to start studying for the second Linux certification, this will advance me to the third Linux information security certification that I will search for, this certification is divided into two and the two parts are marked by two different codes: 201-450, 202-450

In this post I am going to go over each topic as listed on the LPI website, which means I will go over each tool and present it here, in each chapter I will show how to use these tools to get the same information that the subject of the test should deal with, at the end of each chapter I will present a challenge From most of the commands we learned and challenged you and me how to get the information to succeed.

If you want a brochure that deals with the topic extensively regardless of this post I recommend the booklet by Snow B.V. Her name: The LPIC-2 Exam Prep 6th edition, for version 4.5. This booklet helps me a lot and I recommend going through it at the same time, and yet I will try to elaborate as much as possible in the post here to be ready for the test.


- [Chapter 0](#chapter-0)
- [Chapter 1](#chapter-1)

# Objective 201-450

## Chapter 0
## Topic 200: Capacity Planning

Before we start I think is good to memorize way we here to learn linux, just think about world without linux, the power that linux give us and the world is limit less, we can take that technologist and use it to bring new ideas and invention to the world. So at the start I think it is good to take a look of some comedy short video that I found.


<iframe width="560" height="315" src="https://www.youtube.com/embed/GqMAj8udtDo" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>


In this chapter, we need to address computer hardware issues and how to use Linux to make sure that, such as system resources and resources, it is important to know these concepts because these tools can help us deal with the resource utilization problem, and we may run software only after a long time Since running it, or it is possible that only a certain program after a certain operation will consume all the resources on the computer, in this case we want to know how to look at the resources and check which component utilizes it.

In this way we can know which program is the problematic and which program causes the computer to work slowly and even freeze. Most of the tools we present here are tools that show you how to see what your computer's CPU is used for, what software is currently working, how many free memory we have, and a few other things to help us understand how the Linux operating system works.

### stress

In our case we can start some virtual machine to get ready and learn the commands, but how can we demonstrate some memory issues or CPU's problems? in that case we can use **stress**, that command can load up our memory and CPU's to 100 percentage which can be handy if we want to view such issue with the command that supposed to help us find the program that cause to that issue.

I am use Ubuntu, and like on other system operation, I have system monitor that can help me to view my processes on my linux machine, if some program take more CPU than others I may feel like I have sort of slowness in my computer, so, using the system monitor can be handy to find what is the problem in my case.

![OSCP Post](/assets/images/lpic2/systemmonitor.png)
**Figure 1** System Monitor.

If some program utilizes the CPU overly you will see it on system monitor, on the resource the grap will jump up and on processes tab you can find what program utilizes how much from you CPU or memory, let's run the following command.
```
stress -c 1
```
This command will **dispatching the hug** lol! it utilizes one core of your CPU, in my case I have 4 CPU, so one of them will be loaded and I can see it on my system monitor resource tab.

![OSCP Post](/assets/images/lpic2/sysmonstress.png)
**Figure 2** System Monitor, one CPU are loaded over.

If I check out my processes list I will find that the stress program are running and utilizes at least 25% of my all CPU.

![OSCP Post](/assets/images/lpic2/stressthecpu.png)
**Figure 3** Stress program utilizes.

You can also run stress to utilizes the RAM, in that case you specify how much chunk you want to use, every chunk are 256mb, in my case I have 4 giga memory to use so to load it up I can run 15 chunk which is 3840 megabyte in total.

![OSCP Post](/assets/images/lpic2/ramstress.png)
**Figure 4** Stress the RAM.

You can see all of my `C^` keys because I freak out, my computer was freezing and I can't do anything but the `ctrl+C` command, so now ufter it done I run 6 chunk that will not going to crash my system but at least I will be able to view the RAM used.


![OSCP Post](/assets/images/lpic2/ramstress2.png)
**Figure 5** Stress the RAM again.

You also can see on the resources that my memory really over load and my RAM is over 55% used and also my swap is over 59%, please remember that the swap is your virtual memory that run on your hard disk, which mean in my case on the hard disk I have 4 giga memory that been used as swap, if you see such of thing this is not normal and maybe the system are loaded, becouse as default the swap memory will never been use unless the regular memory are over and that the swap get to use.


![OSCP Post](/assets/images/lpic2/resourcesramstress.png)
**Figure 6** Stress the RAM, in resources.

You can also use stress to load the system by using that hard drive, just type the following command, that command can affect the **io** which is the input/output wait and called **i/o block**, this is a processes queue, if for some reason one process can't run because the CPU are over loaded, that process will wait on until the CPU can handle it, the worst thing about that is that this process is on **uninterruptable sleep** mode which mean that you can't even killed it.

```
stress --hdd 1
```

But let's say that you are working at company X, and there you have some linux server without GUI, so in that case you may what to be familiar with the command that can help you to find the problem via terminal.

### Top

That command can give us the same as the system monitor, you can view the percentage of CPU, RAM and more in the top table, so let's look at that.

![OSCP Post](/assets/images/lpic2/top.png)
**Figure 7** top on terminal.

 By typing the **top** commend, as you can see, it bring me table that refresh every 3 second by default, you can change that value by using the `top -d 5` command for 5 second, or inside the top screen press **d** and it will ask you to setup new interval for screen update.

 ![OSCP Post](/assets/images/lpic2/topd.png)
 **Figure 8** Change interval with d.

 You also can see the CPU in percentage, if you have 1 CPU that mean using full of that will be 100% and you will see this number on the cpu in the top command, if you have 4 CPU than if one of them are on the 100% utilizes, than in CPU field you will see 25%. You can also view every CPU separately by press 1 on your keyboard.

 ![OSCP Post](/assets/images/lpic2/4cpu.png)
 **Figure 9** Display every one of my CPU.

 The information for every field over the CPU are as follow:

 us: user cpu time (or) % CPU time spent in user space<br>
 sy: system cpu time (or) % CPU time spent in kernel space<br>
 ni: user nice cpu time (or) % CPU time spent on low priority processes<br>
 id: idle cpu time (or) % CPU time spent idle<br>
 wa: io wait cpu time (or) % CPU time spent in wait (on disk)<br>
 hi: hardware irq (or) % CPU time spent servicing/handling hardware interrupts<br>
 si: software irq (or) % CPU time spent servicing/handling software interrupts<br>
 st: steal time - - % CPU time in involuntary wait by virtual cpu while hypervisor is servicing another processor (or) % CPU time stolen from a virtual machine<br>

 By default the CPU tab are sort, which mean that you can see what program take more CPU than others, if you want to change this sort and resort it by memory, you can press on `shift+>` that will sort the right column which is the RAM.

 ![OSCP Post](/assets/images/lpic2/topmem.png)
 **Figure 10** Sort the MEM.

 If I will run stress now for check the cpu on the top, my cpu can cam up to 100% only if I type the command as follow:
```
stress -c 4
```

 You can see that my CPU is nearly a hundred percent, so this is mean that if I done `stress -c 1` it only load just one CPU core. The same will be in the case of memory as we saw earlier.

 ![OSCP Post](/assets/images/lpic2/cpu100.png)
 **Figure 11** CPU on 100%.

 If I will load my hard drive which mean in our case to use `stress --hdd 1` command, this can change the value of i/o wait time, on the top you can find it under **wa** field.

 ![OSCP Post](/assets/images/lpic2/topwa.png)
 **Figure 12** Wait time are loaded.

Again, this case mean that we have process that use the hard drive and there is a program that on wait state that in sleep mode that we can't kill.

### vmstat

In that command we can view the memory that being used and CPU values, i/o and system utilizes, if you type this command you will get that information but that it, not like top that refresh itself every 3 second by default, but you can run it with refresh like, by using **delay** and **count** option. In the delay you specify how long to wait between every time it display you the information, the count is how many time it will repeat it self, in that case you can see the changes along the way.

```
vmstat 3 5
```

In that case this command display report every 3 seconds and repeat that five times, as you can see on the output I have, the free memory change every 3 second and so in the cpu and i/o.

![OSCP Post](/assets/images/lpic2/vmstat.png)
**Figure 12** vmstat, 3 seconds delay, 5 count.

You can view also only the disk i/o that display the read and write statistics by using `-d` option or memory statistics by using `-s` option. The following is the way to view the table in **wide** mode, it's display more readable table which can help understand more.

```
vmstat -w
```

![OSCP Post](/assets/images/lpic2/vmstatwide.png)
**Figure 13** vmstat wide mode.

You can combain the option as follow:

```
vmstat -w 3 5
```

I have being seeing people that use that command in their program to track the operation of the memory and CPU, in the case of issue with the resources we have, you can find more useful commands than that.

### free

In that command you can more easily understand your free memory that using mvstate in my opinion, because it allow you to view that memory by using megabyte instead of kilobyte that requires you to calculate these values.

```
free -m
```
In my case I have 3823 MB memory in my computer, the memory that are used is 1999 MB and free memory is 124 MB, the shared memory in my case are 208MB, this is mean that there is a two or more process that can access that common memory, the buff/cache are the memory that in the buffer or cache, the consept of that is that if you used some program and close it, that memory going to cache, if you will open that program again, the memory are cached in, so it can bring up the program more quickly. However, if you need this memory, it will allow you to use the memory and get of the cache. In my case the memory that as being cached are 1699MB, available does include free column + a part of buff/cache which can be reused for current needs *immediately*.


![OSCP Post](/assets/images/lpic2/free.png)
**Figure 14** free memory in MB.

```
free -h
```

You can also use the **-h** option which stand for human, it can help you more clearly to view the amount of memory that are used or free.

![OSCP Post](/assets/images/lpic2/freeh.png)
**Figure 15** free memory in GB.

You can also use count which can help display the output several times like in  the vmstate, but we haven't delay option, the delay will be 1 second.

![OSCP Post](/assets/images/lpic2/freecount.png)
**Figure 16** free 3 times count.

The swap memory shouldn't been used, because as we saw earlier that memory should be available only for case we have no memory to use in our system. In my case the was are use more that 300MB, which is note so good, because as I said that was normally are on value of 0. In Ubuntu the default value of the swap that can being used although we have free space in the memory is 60% of the swap in total, we can view our swap value in by using the command `cat /proc/sys/vm/swappiness`, in order to change that value we can use the following command:

```
sudo sysctl vm.swappiness=10
```

Please note that in the case of **sysctl**, the changing of swap is temporary value, which mean after reboot the value will go back to the last value, to make sure this value be permanent we need to change the **vm.swappiness** on the `/etc/sysctl.conf` file. The recommended value for the swap is 10% as much as I know, but you can experiment it.

I use the following command for look on my memory changing:
```
stress -m 6
```

In that case you can see that swap are really working hard and the cache was release a bit, this is mean that my system going buggy behavior, and now we need to find what causes this issue.

![OSCP Post](/assets/images/lpic2/freestress.png)
**Figure 17** Memory are load up.




### iostat

According to man page, the iostat report Central Processing Unit (CPU) statistics and input/output statistics for devices and partitions. The iostat is a part of the **sysstat** package which mean that this packets contain several other tools and one of them is iostat, in my case I use Ubuntu, but if you are using some other operation system that doesn't have that tool, just install it on you distribution, if it's Debian like, you can use apt-get, if it is Fedora like, you can use yam, in my case to install the sysstat package I run the following:
```
sudo apt install sysstat
```

By running the iostat we can find information about our i/o on our system.


![OSCP Post](/assets/images/lpic2/iostat.png)
**Figure 18** Output of iostat.

The ouput contain the linux kernel version, which is Linux 4.15.0-66-generic and my PC name which is zwerd. you can also see the date (although for just date we use date command). we also can see the type of our operation system which is 64 bit in my case, and that I have 4 CPU available. avr-cpu display the CPU for every of the following

**%user** - The CPU that used at the user or application level.

**%nice** - Every process consume the CPU, for every process there is a priority that can be use to decide who is more important and who is not, if you have up to 10 process on the backgound and they want to use CPU, the high-priority process will get consume the CPU before other, in that case the nice value will be negative which mean high-priority for that process.

**%system** - show the percentage of CPU utilization the been use by the kernel.

**%iowait** - stand for input/output wait, this is show the percentage of time that the CPU or CPUs were idle during which the system had an outstanding disk I/O request.

**%steal** - Show the percentage of time spent in involuntary wait by the virtual CPU or CPUs while the hypervisor was servicing another virtual processor.

**%idle** - Show the percentage of time that the CPU or CPUs were idle and the system did not have an outstanding disk I/O request.

Let's load up my system to see the changes on our output, I use the command `stress --hdd 1`, if we use top command we will see the **wa** load up, which mean that we have many process that in wait time state and they wait for CPU that can process them.

![OSCP Post](/assets/images/lpic2/waittime.png)
**Figure 19** I/O wa by using top command.

We can use **-x** for extended information that include utilization as well, we also can print out the output as that same way we done on vmstat, it can display output multiple time and delay from each as follow:
```
iostat -x 3 5
```
In that case it will print out every 3 second, 5 times.

![OSCP Post](/assets/images/lpic2/iostatx.png)
**Figure 20** iostat with extended.

After I load up my hard disk by using stress, this what I got on the iostat output, you can see that the values on the output load a lot.


![OSCP Post](/assets/images/lpic2/iostatx2.png)
**Figure 21** iostat loadup.

If you have more than one partition, you can use the option **-p**, this option displays statistics for block devices and all their partitions that are used by the system, you can also display it only for one partition by specify that partifion.
```
iostat -x -p sdb
```
![OSCP Post](/assets/images/lpic2/iostatxp.png)
**Figure 22** iostat for specific partition.

### sar

If you want to see the iowait like we saw on iostat but in the form of a display like in TOP command, you can use sar command. This command print out the current status of the  nice, system, iostat and others, you can use it to see on real time the status of your system activity.

![OSCP Post](/assets/images/lpic2/sar.png)
**Figure 23** sar command.

In my case I use sar to display state every second for 5 times, as I already write above, sar is part of sysstat, so if you have some issue to run it, you need to check that it's enable on the file `/etc/default/sysstat`:
```
#!/bin/bash
# Default settings for /etc/init.d/sysstat, /etc/cron.d/sysstat
# and /etc/cron.daily/sysstat files
#

# Should sadc collect system activity informations? Valid values
# are "true" and "false". Please do not put other values, they
# will be overwritten by debconf!
ENABLED="true"
```

You can run the command `sar -r 1 5`, the **-r** option stand for Report memory utilization statistics, on the output you can find the KBCOMMIT and %COMMIT which are the overall memory used including RAM and Swap.


![OSCP Post](/assets/images/lpic2/sar.png)
**Figure 24** sar memory used.

### iotop

If we found that we have some issue on the hard disk because let's say we found on the iostat command that the i/o work really hard by view iowait that jump up to bigger number or by write and read values from the disk are greater then other, we can find out which program causes that problem, just type iotop.

![OSCP Post](/assets/images/lpic2/iotopstress.png)
**Figure 25** iotop example.

In my case you can see that he tell us that the most utilizes program in the IO of our hard disk is stress, you also can see that he specify the hdd by side of that, which tell us what option has being used in stress command.

In the iotop you can also see the swapin value, and in my case as you saw earlier, my swap are really utilizes by some program, so I checked it out and find what is the program that used my swap.

![OSCP Post](/assets/images/lpic2/iotopswap.png)
**Figure 25** iotop swapin view.

### lsof

This command list open files on your system, which mean you will see all files that are use under you username, so if you run that command it is not very useful, but I tell you what, if you feel like you have some memory issue of hard disk working hard and you check and find what program are running, you can run `lsof` and grep the program you suspect that make you the issue, and then you can see exactly what files are open with that related to this program.


![OSCP Post](/assets/images/lpic2/lsof.png)
**Figure 26** lsof.

Let's run stress command for utilizes the hard disk and see if we can find the stress files.

![OSCP Post](/assets/images/lpic2/lsofstress.png)
**Figure 27** lsof stress files that are in use.

As you can see the binary file are in use, if you see that your computer are leak of speed because of some program and you want to check what files are used by that program, the lsof can be the solution for you.

### uptime

This tool can tell you the how long the system has been running, also you can find out how much users connect to this PC and what is the load average, the load average first number represent the load time average for 1 minute, the second is for 5 minutes and the last one is for 15 minutes.

![OSCP Post](/assets/images/lpic2/uptime.png)
**Figure 28** uptime.

You can view the exec time in nice mode that can be display.

![OSCP Post](/assets/images/lpic2/uptime2.png)
**Figure 29** uptime.

### w

This command show who is logged on and what they are doing, you  also can use the **who** command, but this command can be handy in the network cases, let's say that some one connect to your computer or server remotly, you can use this `w` command for checking out what is the source ip of that user.

```
w -fi
```

The **-f** option stand for from filed that will be specify on the output, the **-i** display on that line the ip address rather the

![OSCP Post](/assets/images/lpic2/lsofremote.png)
**Figure 30** remote connection.

You can see that I have two connection that one of them have IP address, I made this connection from other PC to my local computer, the first line specified my local user. You also can see that the remote user use `zsh` program remotely, if I change it to bash on my other PC I will see that on the `w` output

![OSCP Post](/assets/images/lpic2/lsofremote2.png)
**Figure 31** Using bash instead of zsh.

### netstat

This tool can help us to find out on the network level processes that using the network, and many connection that are open between your computer and the local network. But first of all it is important to know how we can look at the network level using netstat.
```
netstat -ie
```

This command will show us our local network interface with his IP address and MAC address which is the physical address of that interface.  

![OSCP Post](/assets/images/lpic2/netstat-ie.png)
**Figure 32** My interfaces network.

It is the same as `ifconfig`, you can also see the TX and RX which stand for transfer and receive of the bytes over that interface, the eno1 is my physical interface while my lo is the loopback, the interface I used right now is wlp2s0 which is my WIFI interface, you can see that the TX and RX on that interface are pretty high, you can grep that by using the "bytes"

![OSCP Post](/assets/images/lpic2/ifconfig.png)
**Figure 33** TX and RX.

We also can use `netstat` to get the statistics of our network interfaces, in that case we will see the count of IP pakets that go though our network interface, we can see the icmp packets that are used for PING traffic and also there is the TCP and UDP packets the go through out interfaces. If we see an error in one of the statistics under specific protocol/field we will know that something on our network are stoping us to get that streem of packets.

```
netstat -s
```
![OSCP Post](/assets/images/lpic2/netstat-s.png)
**Figure 33** Statistics by using netstat.

You can also use `netstat -tuna`, the **-t** stand for TCP connection only while **-u** stand for udp, the **-n** will show the numericla address instead of trying to find the hostname, **-a** stand for show both listening and non-listening sockets, so by running this command we can see the connection that are running over the network and their address


![OSCP Post](/assets/images/lpic2/netstat-tuna.png)
**Figure 34** Statistics by using netstat.

The command I love to use is `netstat -aenp` that can show you the program who use the connection and their process ID number which can be handy to find some process that use the connection and stop it by that ID number.

![OSCP Post](/assets/images/lpic2/netstat-aenp.png)
**Figure 35** Process ID of networking connection.

### TIP

If you found some program that make some issues on your commputer, let's say that you run some script or some tool on your command line or you have some program on the GUI and you want to kill it, in that case you may want to know what is the ID number of that process, after you find out what is the process number ID, as example of `top` command, you can kill it by using the following:
```
kill -9 <process ID>
```
If the program was run on the terminal and you type `ctrl+z` that it is on suspended state, this is mean that you can change that state and load it again or just kill it. For killing it you need the proccess ID, and if you didn't record the number ID you can't find that process on the `top` because is on suspended, so to find this process ID you can type the follow:
```
ps -aux
```
This ps command can show you what is the process ID that are suspended and after that you can kill it. in the case of **-aux** options, you will see all the process that run under your user, you also be able to see the command you type and suspended under the COMMAND column.

If you want to view in more visualize mode you can use `pstree`, this command display tree of process, that's mean that you can more quickly understand how is the parent and child of process. if you use `pstree -a` you will see the agrument of the program or command that are run on your system. If you want to see specific process on the list you can type the `pstree -H <PID>`, in that way the all tree print out on the screen but every process that related to chrome will be highlighted.

![OSCP Post](/assets/images/lpic2/pstree.png)
**Figure 35** Chrome process ID using pstree.

If you wnat to see just that process without all the tree we can use `pstree -s <PID>`.

![OSCP Post](/assets/images/lpic2/pstree-s.png)
**Figure 36** Chrome processes.



In the network cases process you can also use very handy command that can bring you more relevant information, as example let's say that we want to see the bandwidth and the statistics of the utilization of that bandwidth with connection information like source and destination address, well for that case we can use `iftop` command that can bring us information in real time about the traffic that go through out network interface, you can see by using that command the amount of bandwidth that are utilize by which host that have connection to our local computer.

![OSCP Post](/assets/images/lpic2/iftop.gif)
**Figure 36** bandwidth of connection in real time.

You can to see in real time the traffic that I have on my wlp2s0 interface. The bigest connection trafic will be on the top of the list and that can give you a clue if you have some program that take advantage of all your bandwidth you can see which is the destination address and go back to the netstat to check what is the process that run this connection.

Another handy tool you can use is `nload`, this tool are monitor your bandwidth load, which mean you can see if you have a lot of traffic going on the incoming side or outgoing of you interface, in my case I connect to Mint Linux site to download some iso file that you can see my graph changing on the `nload` command.

![OSCP Post](/assets/images/lpic2/nload.gif)
**Figure 37** Using nload and iftop to see the download traffic.

The graph load up and on the iftop we can see the address that have a connection to my computer which from him I download that iso file.

You can also use `iptraf` or `iptraf-ng` these tools allow you to see the connectiviry of TCP connection that came to your computer.

![OSCP Post](/assets/images/lpic2/iptraf.png)
**Figure 38** TCP traffic.

### Network Monitoring

Let's say you work at the IT position on some organization and you got some call from the support team that tell you they have some client that his computer work slowly in every action over the network or internet, in that case you will need to check and troubleshoot that issue, you need to find out if the slowness appear when the client work on the internet or on his local network, to do so we have many tools that can help us in these cases.

One of that tools are the `iperf`, this command can check the bandwidth between two point over the network, this is mean that we can use it to check if the local network have the slowness issue of not, the other tool you can use is **speed test**, you can find one on online website that can check the bandwidth between you and the internet, in that case you will be able to see if the slowness are appear over the internet.

 Let's start with speed test that I found *speedtest.net*, you just need to click the button and this site will give you the details.

 ![OSCP Post](/assets/images/lpic2/speedtest.png)
 **Figure 39** Speed Test.

In the case of `iperf` we have two mode, server mode and client mode, it dosn't matter were you run each mode, what is matter is what is the bandwidth between them, on the client side we need to run `iperf -c <server address>`, on the server side we just need the command `iperf -s`, after we run it the detail about the bandwidth between the server and client will reveal.

![OSCP Post](/assets/images/lpic2/iperf.png)
**Figure 40** Iperf.

You can see that in my case the bandwidth from my computer to another in my lab is 2.57GB which is good for me, in the case of our example that you have client that complain about slow network, you may have to check several thing, the first one is to check his and other computer connectivity out of the local network with speed test, after that you will go to the second check which is bandwidth test between two local computer. If on the first test using the speed test, let's say you found that the client computer work slow by speed test and other computer aren't, then you run the second test which is the iperf and found low bandwidth connectivity between the two, in that case it's mean that we have local network problem that can be found on the local network interface or the nearly network device like switch or router.

On the LPI site under 200.2 object you can found that they want the student will have awareness of monitoring solutions such as Icinga2, Nagios, collectd, MRTG and Cacti, well these programs can be install on you computer or other server and you can monitor the resource you have, but the Cacti is monitor program for network connectivity and so the collectd, so I don't really understand way they want to have a knowledge of these program, in the day day life I don't thing I am going to use such program to monitor my network resource, but in the case of these program, all of them work in the browser, this is mean that you have some URL and you can view the bandwidth or interfaces status etc.

### Challenge

1. create some large file that contain more that 100MB.
2. Transfer that file from other computer in your lab by using `nc` command.
3. Check and view the transformation and bandwidth utilization.
4. Check the CPU and RAM used during the transformation and find the PID.

This is simple challenge but it can help us to rule the commands we learn so far, I know that there is a new command in that challenge like `nc`, but it you going to linux field you need to have a clue how to solve issue and problems alone by searching the solution and be comfortable with new commands on cli.

### 1. Create file of 100MB

To create large file I used the `fallocate`, this command can create for you file in any size you will need, in my case it was very useful.
```
fallocate -l 100M megafile.pno
```

This is not really matter what extension for that file you will create, what is matter is that file are in the size we want which is 100 MegaByte.

![OSCP Post](/assets/images/lpic2/ls-l.png)
**Figure 41** ls -l.

### 2. Transfer the file you have to other computer in the LAB.

I created that file on my Kali linux so I tryied to transfer it back to my Ubuntu, on my Ubuntu I set up the netcat to play as server with the following command
```
nc -vlp 1007 > megabyte.png
```
On the client which going to be my Kali linux, I run the following command:
```
nc -v 172.16.1.0 1007 < megabyte.png
```

Please note that in my segment the subnet contain more than 254 address which is classless of 23 as prefix, also note the redirection, on the client side I redirect the megabyte.txt file to the connection that I am going to have with netcat, on the server side I redirect the output from netcat to the megabyte.txt which will going to be the same as on my Kali.

![OSCP Post](/assets/images/lpic2/nc.png)
**Figure 42** Netcat on my Ubuntu, the address is of my Kali.

### 3. Check bandwidth and utilization.


Wile the file are transfer I run on my Ubuntu the command we saw earlier to view the utilization of the bandwidth on the network interface, the first one was `nload` command that will give us the information in a half of second what go through in your interface.

![OSCP Post](/assets/images/lpic2/nloadcheck.png)
**Figure 43** nload on my Ubuntu.

I can see that there is a tranformation or more likely data that go through my interface network, but I can see the connection it self, that go in and out through my interface, in that case I needed to use `iftop` which can tell us each connection what is the source address and the destination.

![OSCP Post](/assets/images/lpic2/iftopcheck.png)
**Figure 44** iftop on my Ubuntu.

You can see the address 172.16.1.0 which is my computer, the Kali has the 172.16.0.251 address, so now we know that there is connection between us and other machine and we know that data are transfer in this connection.

### 4. Find the PID of the utilize program.

Now let's say that we want to check the state of our system, like checking the CPU and RAM that used, I run the `top` command and found some process that showed up on the top of my list, so this is the process that I want to look at it.

![OSCP Post](/assets/images/lpic2/topcheck.png)
**Figure 45** top on my Ubuntu.

You can see that I have the PID, so now we want to find and check the state of disk IO, because remember, if there is utilize of the CPU and RUN, something like that can be a program that run on our disk, in my case I know that some program are running on my Ubuntu, so I run `iotop` command which can tell me what was done on the disk.

![OSCP Post](/assets/images/lpic2/iotopcheck.png)
**Figure 46** iotop on my Ubuntu.

Now you can see by filter the PID we found earlier and found the program that run on our PC, in my case it's `nc` program and it's also showed me part the `nc` command which contain the port 1007.

**Summery:** it is important to know how to read and found information of some program in our linux operation system to deal with utilization issues or network problem, the PID can be your best friend to address the issue out but it's important to know that if we decided to kill process, this action may not be the best solution for that issue, because maybe that problem will appear back again tomorrow, the best solution can be found on the dip level of that issue, we just need to understand why that issue appear and for what it depends, after we found that we may have the ultimate solution that can migrate that issue for best.

## Chapter 1
## Topic 201: Linux Kernel

When we talk about linux kernel we want to be able to find out what is our linux kernel version and how to read that version, which mean how we know if that version is stable or be familiar with more details that this version number contain.

First of all let's check our version number, we can done that by using the `uname -a` command, this command will print out the version number and the name of our machine also time and date and even what is out computer architecture, which is 64bit in my case.

![LPIC2 Post](/assets/images/lpic2/uname-a.png)
**Figure 47** My linux kernel core.

The first number is the version number, in my case it is kernel version 4, the next number is the major revision which is my case is 15 and the third number is the minor revision number, the fourth number is the patch level. In the past, in the version of the kernel was a general rule in the number version, in the second number every odd number was as developed version, and the even number was as stable version, as example the 1.5.2 kernel was under development and version 1.6.2 was known as stable kernel version, when the kernel version 2.6.x came along it stay for long time without numerate the number except the last one number, because version 2.6.was awesome and fourth number for the patch number, one more thing that you need to know is that after thay release the version 2.6, thay get ride of the odd/even number and every new release is stable and not under development, every stable version will develop and update on a new version.

When the version of that kernel raise up and was 2.6.39.4 than Linus Torvalds decided update the enumerating to be more like the old one, which is the first number will be the kernel version, the second will be the kernel release and the third will be the minor revision which is stable or patch to update abilities on the kernel. You may somtime see like a fourth number which play as a path, in my case of **72-generic** this is the Ubuntu specific patch they done.

You can find the versions of kernels that you have in you linux machine under the /lib/modules folder and in each one we can found every modules that are run on our system.

![LPIC2 Post](/assets/images/lpic2/kernels.png)
**Figure 48** My kernels.

We can go to the kernel archive and found there the kernel that are stable and under operation release use. the meaning of longterm is that this kernel version will be available for long time because one of the operation system like ubuntu or centOS or red hat and such may maintain and using this kernel version, this is why you may be seeing some old kernel version in that site.

![LPIC2 Post](/assets/images/lpic2/linuxkernels.png)
**Figure 49** Kernels archive.

If we going to the kernel folder under the kernels version that I showed up earlier, we will see that every module lies on the most appropriate folder.

![LPIC2 Post](/assets/images/lpic2/kernelfolder.png)
**Figure 50** Kernels folder.

In the net folder we will find every module that related to the network card and such, in the fs folder we may found thing that related to the file system, if you want to see every module that are enable on your system, you can just type `lsmod`.

![LPIC2 Post](/assets/images/lpic2/modules.png)
**Figure 51** lsmod to see the modules.

As you can see the modules that are enable print out on my screen with `lsmod`, you can see the module name and it's size, you can also see what modules are depends on which of the modules as example the **vboxdrv** module is the module that responsible for the vbox on my PC I guess, and there is three modules that relay and depend on that one which are vboxpci, vboxnetadp and vboxnetflt.

You can remove module by using `rmmod` you just need to know what is the module name, as example, let's say that we want the floppy out, so we can grep it in `lsmod`.

![LPIC2 Post](/assets/images/lpic2/lsmodgrep.png)
**Figure 52** find out the floppy by `lsmod`.

Now, in order to pop it out we need to use `rmmod` with the name of that module.

![LPIC2 Post](/assets/images/lpic2/rmmod.png)
**Figure 53** Remove the floppy module.

If we want the module back in, we need to use `insmod`, but for insert back from the dead some lost module we need to let him know the exact path for it. we can use `find` for finding that module.

![LPIC2 Post](/assets/images/lpic2/grepfloppy.png)
**Figure 54** finding the path for floppy module.

We now can use this path to insert that module back in. You can see that now I can find that floppy module in the active module list of `lsmod`

![LPIC2 Post](/assets/images/lpic2/grepfloppy.png)
**Figure 55** Inserting the floppy.

There is another way to remove module from the active list by using `modprobe`, in this command we can remove module and insert it back without specified the full path.

![LPIC2 Post](/assets/images/lpic2/modprobe.png)
**Figure 56** Modprobe for remove and adding module.

The command `modprobe` know what is the path of every module by using the **modules.dep** file, this file contain every module and it's information and dependencies, to update this file we can use `depmod -a` that will go and insert the information of the modules to this file.

important thing you may want to know is that module that have dependencies can't be remove out because it in use, in that case we will need to remove the modules that are use this module.

![LPIC2 Post](/assets/images/lpic2/modprobe-r.png)
**Figure 57** Remove module, error because it in used.

We can get more information about the module by using `modeinfo`, by using this commend we can found the path for that module, dependencies, version and more parameters that module have, so, in case we want some module use specific parameter, we will remove that module and use `modprobe` to insert it with the relevant parameter.

![LPIC2 Post](/assets/images/lpic2/modinfo.png)
**Figure 58** Module info by using modinfo.

As you can see the usbcore have the param nousb which is boolean, you can insert that module and using that param as example `modprobe usbcore nousb=N`.

Please remember that all we talk about are the modules and not the kernel option itself, like enable the NAT operation for example. Option like that can be found on /proc/sys/kernel, in this folder you will found every option that are enable on your carnel, if you want to watch the configuration file which from there you enable them, you need to check the sysctl.conf that can found on the **/etc** folder, in that file you can enable more functionality of the system, like enable ip forwording or such.

You also have the command `sysctl` which can help you to see add change the option of your operation system


![LPIC2 Post](/assets/images/lpic2/sysctl.png)
**Figure 59** View the option that enable on my PC.

As an example we want to change some value of the running setting:

```
sysctl -w vm.vfs_cache_pressure=80

```

This command will change the vfs_cache_pressure to value of 80, but please note that this change are made on the running kernel, which mean if you go for reboot the default setting will come in place, if you want to make this changes permanent you need to make these changes on the sysctl.conf file.

You may ask how the linux kernel knows when some device pluge in and lunch his apropriate module, this is done by the **udev**, this udev responsible for such a thing so he know to load up the usb module when some USB device pluge in.

You can see what going on your commputer by using some command that related to udev, such as `lsusb` which can show us the devices related to usb,`lspci` that responsible for CPI bridge or the `dmesg` that show us all the log we have from the system like in the boot which we can see on the boot the logs that our system run while bring the OS up.

 We also have the `udevadm monitor` which can bring to the screen logs from the system in real time, you can see on the next gif how it work, I pluge in my sundisk device and he found it and load it's logs to my screen, he also showed us the remove log when I remove my device from that computer

 ![LPIC2 Post](/assets/images/lpic2/udevadmmonitor.gif)
 **Figure 60** UDEV monitor in real time.

You also need to know that there is a blacklist of modules because let's say that you pluge in some device that have number of driver on you kernel that can support it, but you may want to use just one of them that are the best used for you.

![LPIC2 Post](/assets/images/lpic2/blacklist.png)
 **Figure 61** blacklist.conf file.

In my case you can see that in the blacklist I have the
eepro100 module which mean that if ethernet card pluge in, do not use that old driver, so that is the purpose of that blacklist.
