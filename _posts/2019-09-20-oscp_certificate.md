---
layout: post
title: OSCP Certification Journey
excerpt: "I set myself a lot of goals this year to advance to the next level, among all the goals being the OSCP certification from Offensive Security. It's been a certification I've been talking about for years, since 2012, it's really time to sit down and do that certification. It all started when I was writing in a forum on computer communications, where I presented the dilemma, whether to study information security of companies that are involved in the field or something else when my goal is to be an expert in the cyber world."
tags:
- Pentest

---


I set myself a lot of goals this year to advance to the next level, among all the goals being the OSCP certification from Offensive Security. It's been a certification I've been talking about for years, since 2012, it's really time to sit down and do that certification. It all started when I was writing in a forum on computer communications, where I presented the dilemma, whether to study information security of companies that are involved in the field or something else when my goal is to be an expert in the cyber world.

Eventually, someone responded to me, depending on what I want to learn, whether I want to be on the attacker or on the defensive side, he introduced a number of certifications and wrote about each certification separately. Among all the certifications he presented were Cisco certificates, Check Point certificates, and all sorts of large companies that manufacture and market security sites that protect the entire corporate network.

The certificate that I saw among the list included Offensive Security and dealt with the Offensive field with the goal of giving the student tools to perform penetration tests. I went into their site and saw that the whole Offensive area is divided into several levels and on each level there is another part which is a whole world.


![OSCP Post](https://miro.medium.com/max/939/1*34gCma82FiLxCWQhhq4A6g.png)
**Figure 1** Offensive Security.

I decided that was what I wanted to do, as Joseph McCray said in his lecture on Defcon 17, "That's what I'm going to do."

![OSCP Post](https://i.ytimg.com/vi/-AkUutmXwUI/maxresdefault.jpg)
**Figure 2** Joseph McCray on Defcon 17.

After you finish the exams, which are made up of a lab that has a number of boxes to break, you get a certificate on their behalf with an Offensive card, and anyone who knows me knows I love these wallet cards.



![OSCP Post](https://miro.medium.com/max/1200/1*Rr2jJWBuAHgMNd6zbReMBQ.jpeg)
**Figure 3** OSCP Certification with wallet card.

In short, this year it is time to do this certification and not give up until I finish the whole book. There is a booklet that goes around the Internet, if you are interested in the booklet and you do not find it, email me and I will send the booklet to you.


In this post I will present my studies and maybe later I will make some videos that show how things work.

If you are familiar with Linux, getting started with the material will be easy for you, if not then it is better to get acquainted with the Linux operating system and return here to continue learning. In this course we deal a lot with the Kali operating system which is Linux based and very similar to Debian.


Kali contains a lot of tools for performing attacks or planning actions and the Ofer work with it is no different than any Linux system that exists. So let's get started

## Find, Locate and Which

These all three commands work the same, they allow you to find location of some file, the difference is that every one display results in other way.

Before you trying to use these commands you need to update your database which is contain the location of every file on the database

**updatedb**

By run this command a mlocate.db file will created and this is how the locate or which and find can locate every file on your computer

![OSCP Post](/assets/images/oscp/updatedb.png)
**Figure 4** In my case I had to run into sudo because of permission I'm guessing.

After that I run the **which** command, this command find the location of directory that defined on $PATH,

![OSCP Post](/assets/images/oscp/which.png)
**Figure 5** In my case I had to run into sudo because of permission I'm guessing.

If you check the &PATH by using echo $PATH you will find it, in my case I used *which zsh* which is my command line command that I love to use on my ubuntu, on the $PATH there is a /usr/bin folder which contain my zsh folder.

![OSCP Post](/assets/images/oscp/path.png)
**Figure 6** My $PATH that contain zsh in side /usr/bin/

The **locate** command used for find some file, when you run this locate it display to you with the full path of the file you search for.

![OSCP Post](/assets/images/oscp/locate.png)
**Figure 7** locate command.

Please remember, if you run the locate with part of the name string of the file, it will find every file that contain that string.

The **find** command is more aggressive, with that command you can find every file by specifying directory, in my case I search for USB2.0.exe, but let's supposed that I don't know all of that file string, so I can write as the following.


![OSCP Post](/assets/images/oscp/find.png)
**Figure 8** find command.

In that case I search on specifying directory and append **"*"*** to USB and find every such file that contain that string.


## Changing Password

If you install Kali you probably didn't ask for use and password, so the default user and password will be as follow:
**username: root
password: toor**

It's a good idea to change the password to the machine, if you make an attack and someone comes at you, you probably don't want it to be able to log you into the machine and see what you do. For that case we use **passwd** command.

![OSCP Post](/assets/images/oscp/passwd.png)
**Figure 9** passwd command.

## telnet

The telnet command being around since 1969, we used telnet for connect to remote machine terminal or cli, we can  using telnet to connect from our linux machine to remote windows and versa. in the most cases telnet service used port 23 which we can change it and use other port.

I think the most open telnet terminal over the Internet is towel.blinkenlights.nl, you can try it yourself and it will bring you to terminal that present the start wars movie.

**telnet towel.blinkenlights.nl**

![OSCP Post](/assets/images/oscp/starwars.png)
**Figure 9** starwars over telnet.


## SSH

SSH is our way to use remore connection like telnet but as more secure way. On telnet everything transferrer as clear text, on ssh it encrypt the all the session between two point. If you wnat to check if you ssh are running or check it status you can use service command.


![OSCP Post](/assets/images/oscp/sshdown.png)
**Figure 10** SSH Service.

In my case the ssh are down, so to bring it up I need to run the following, please note that for exit the operation you can press on Ctrl+C or just **q**.

![OSCP Post](/assets/images/oscp/sshup.png)
**Figure 11** SSH Service.

We also can check if the service is using port 22 as ssh do by using netstat. In my case I using grep to included only sshd.

![OSCP Post](/assets/images/oscp/sshcheck.png)
**Figure 12** SSH Service.

In many cases you, like many, will wanna to setup ssh for run at start time of your machine, to do so you will need to use **update-rc.d** which is script that allow you to enable services to run on start time. you also can check what service enable on update-rc by view rc<number>.d folder.

![OSCP Post](/assets/images/oscp/sshonrc.png)
**Figure 13** SSH Service.

## HTTP

We can use in HTTP service to do several thing on the penetration, as example bring up some web and perform some action that make out victim to download some file from our hosting machine. In the most of the time if someone connect to some web server (which dosnt include secure connection), he likely going to use port 80 to connect this site. On linux we use most of the time apache2 service to bring up some web services the host on our machine, to start apache we will use the service command.

![OSCP Post](/assets/images/oscp/apache2.png)
**Figure 14** apache2 Service.

Again, you can check it by using the netstat command that will show you if the port active on LISTEN. In my case I using grep for display only service that using port 80.

![OSCP Post](/assets/images/oscp/apache2netstat.png)
**Figure 14** apache2 Service.

**tip:** To check what every option on netstat or any other command does, you can use man page by typing **man <command>** and it will bring you up for the manual of that command. In the case of netstat **-a** mean display all the active ports, **-n** display in numeric form, **-t** display only TCP protocols and not other like UDP, **-p** display the PID of that program.

![OSCP Post](/assets/images/oscp/manpage.png)
**Figure 14** apache2 Service.

After that, if you want you can see the web you are hosting on you computer by using the browser, you will anly need  to check your local address with port 80 or type 127.0.0.1:80 on your browser.

![OSCP Post](/assets/images/oscp/apache2site.png)
**Figure 14** apache2 Service.
