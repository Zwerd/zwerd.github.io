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


# Objective 201-450

## Chapter 0
## Topic 200: Capacity Planning

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

You can also use stress to load the system by using that hard drive, just type the following command, that command can affect the **io** which is the input/output wait and called **i/o block**, this is a processes queue, if for some reason one process can't run because the CPU are over loaded, that process will wait on until the CPU can handle it, the worst thing is that this process is on uninterruptable sleep mode which mean that you can't even killed it.

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

 If I will load my hard drive, this can change the value of i/o wait time, on the top you can find it in the wa field.

 ![OSCP Post](/assets/images/lpic2/topwa.png)
 **Figure 12** Wait time are loaded.

Again, this case mean that we have process that use the hard drive and there is a program that on wait state that in sleep mode that we can't kill.




### iostat

According to man page, the iostat report Central Processing Unit (CPU) statistics and input/output statistics for devices and partitions. The iostat is a part of the sysstat package which mean that this packets contain several other tools and one of them is iostat, in my case I use Ubuntu, but if you are using some other operation system that doesn't have that tool, just install it on you distribution, if it's Debian like, you can use apt-get, if it is Fedora like, you can use yam, in my case to install the sysstat package I run the following:
```
sudo apt install sysstat
```

By runing the iostat we can find information about our system.

![OSCP Post](/assets/images/lpic2/iostat.png)
**Figure 1** Output of iostat.

The ouput contain the linux kernel version, which is Linux 4.15.0-66-generic and my PC name which is zwerd. you can also see the date (although for just date we use date command). we also can see the type of our opration system which is 64 bit in my case, and that I have 4 CPU available. avr-cpu display the CPU for every of the following

**%user** - The CPU that used at the user or application level.

**%nice** - Every process consume the CPU, for every process there is a priority that can be use to decide who is more important and who is not, if you have up to 10 process on the backgound and they want to use CPU, the high-priority process will get consume the CPU before other, in that case the noce value will be negative which mean high-priority for that process.

**%system** - show the percentage of CPU utilization the been use by the kernel.

**%iowait** - stand for input/output wait, this is show the percentage of time that the CPU or CPUs were idle during which the system had an outstanding disk I/O request.

**%steal** - Show the percentage of time spent in involuntary wait by the virtual CPU or CPUs while the hypervisor was servicing another virtual processor.

**%idle** - Show the percentage of time that the CPU or CPUs were idle and the system did not have an outstanding disk I/O request.
