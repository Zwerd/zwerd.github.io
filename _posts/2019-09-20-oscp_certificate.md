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


In this post I will present my studies and maybe later I will make some videos that show how things work. Important to remember, reading this post requires basic Linux knowledge, browser familiarity, HTML & CSS / JS, computer communication, familiarization with security solutions, and knowledge of Internet usage. If there is something you read and do not understand I recommend searching Google and coming back to read the post after that, I try to expand on everything I present here, but there are things I do not want to overlook.

If you are familiar with Linux, getting started with the material will be easy for you, if not then it is better to get acquainted with the Linux operating system and return here to continue learning. In this course we deal a lot with the Kali operating system which is Linux based and very similar to Debian.

# Chapter 1 - Let's start over

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
**Figure 15** apache2 Service.

**tip:** To check what every option on netstat or any other command does, you can use man page by typing **man <command>** and it will bring you up for the manual of that command. In the case of netstat **-a** mean display all the active ports, **-n** display in numeric form, **-t** display only TCP protocols and not other like UDP, **-p** display the PID of that program.

![OSCP Post](/assets/images/oscp/manpage.png)
**Figure 16** apache2 Service.

After that, if you want you can see the web you are hosting on you computer by using the browser, you will anly need  to check your local address with port 80 or type 127.0.0.1:80 on your browser.

![OSCP Post](/assets/images/oscp/apache2site.png)
**Figure 17** apache2 Service.

## Web Ingredients.

Most of the elements on which many sites are based in the Internet space are: HTML, CSS, JavaScript. Each site contains HTML code, which allows us to choose the style of our text, size, position, hierarchy, etc. At CSS we use to get a more interesting look, change image sizes, add colors, create different font and font sizes, and even build tables, these two components actually make us the body of the virtual machine we created. And here's where JS came into the picture. JS puts far beyond the font or color, is the brain behind our virtual machine, you can make moving images with it, change colors, change font or background sizes, do it automatically by a few seconds or when the user moves the mouse over the background, it all depends You set him up to do.

Since I'm only at the beginning, we won't go into the depth of things, much of what you need to know right now if you don't know HTML is its structure. The HTML is made up of tags just like XML files, we can find inside <html> </html> when the first one opens the document and the last one closes it, all the difference is the small slash **/**. Information that should be hidden from the user's eyes such as a CSS style or a JS file that should be loaded while the page is running will all be written between the <head> </head> tags. Information that the user should see will appear mainly in the <body> </body> document.

There are many other types of tags, such as <img> that we use to insert an image into the HTML page, or the `<a href="/some/url/path"> text <a>` used to create a link that, if clicked, will take us to the url we placed in href, there is the `<p> </p>` used by us to create a paragraph and many other types that can be used by us.

It is important to know that for each tag we want the CSS to handle we will use the example class
```
<p class = "paragraph"> this is test <p>
```

In fact, if we called CSS through a file or we used <style> tags and put something in style there:
```
.paragraph {
font-size: 10px;
color: green;
}
```
The same text that will be written inside the paragraph we created will be 10 pixels in size and green.

JS works in the same way only that for use it we use the `id` option instead of class

Before we move on, I recommend reading some of these topics a bit or seeing a video that talks about them and come back here and keep going. If you have come to challenge yourself and you do not know these concepts, continue to the upcoming challenge.

## Challenges

1. You need to bring up some webpage on your local PC using apache2.
2. The web page need to use other port that 80.
3. The web page need to be simple and contain some link for ssh terminal.
4. By click the link it will open terminal to our PC.

You can do the exercise alone and after that comeback to continue reading and see how I did it, or you can read all it through and do as I done. I encourage you to do this exercise alone, in this way you sharpen your ability to become familiar with the technological space at your disposal to do things that will help you with an penetration test.

### 1. Bring up Web Page

First we need to start apache2, I restart my machine and find that apache2 on down state, so I bring it up.

![OSCP Post](/assets/images/oscp/exc1-01.png)
**Figure 18** apache2 Service.

After I done so, I open my FireFox browser to see if I can view the default page of apache2, on that page I type in **localhost** which is by default use port 80. Also on that page there is some thing that can help us with the exercise, like the configuration of that page.

![OSCP Post](/assets/images/oscp/exc1-02.png)
**Figure 19** apache2 configuration at the default page.

We will use the information of that page for the followup exercise. We also can check to see what is the port address, becouse we cant see it on our browser, so, we use netstat which can bring us that information. In my case I grep that information out.

![OSCP Post](/assets/images/oscp/exc1-03.png)
**Figure 20** netstat information for apache2.

### 2. Setup other port for our localhost wepage.

As was specifying on the default apache2 page, the configuration for port number can find on the foolowing path: **/etc/apache2/ports.conf**. After reading the information in that file I setup new port number **8081** and restart the apache2 service.

![OSCP Post](/assets/images/oscp/exc1-04.png)
**Figure 21** port number configuration.

I use vi to change that, I run it with sudo to be sure that I be able to save the changes becouse of permission issues. I specify **Listen 8081** which tall apache2 to listen to that port and bring up the page.

![OSCP Post](/assets/images/oscp/exc1-05.png)
**Figure 22** Adding port number 8081 to config file by using vi.


I openup my browser again and type my localhost with port number 8081 which look like as folloe: **localhost:8081**, and it bring up the default page again.

![OSCP Post](/assets/images/oscp/exc1-06.png)
**Figure 23** The default page on port 8081.

### 3. Create new web page with SSH link.

On the default page of apache2, specify that if you want to change the html file you can do so by changing the file on the **www** directory. I created new folder named old and moved every file on the **html** directory to this new folder.

![OSCP Post](/assets/images/oscp/exc1-07.png)
**Figure 24** The path for www directory.

After that I was created new file with **touch** command, and vim it to make my new webpage with the ssh link inside it, I used **<style>** for my css web style and make a link with **href**. The address for the remote ssh server is my other linux machine.

![OSCP Post](/assets/images/oscp/exc1-08.png)
**Figure 25** My html file.

after I finish, I went back to my browser and refresh it, my page will bring up with the SSH link that I created.

![OSCP Post](/assets/images/oscp/exc1-09.png)
**Figure 26** New webpage with SSH link inside.

### 4. Click the SSH link to open session to our ssh-server.

After I click the link on my page, I had some issue with the link, the browser dosn't understand what to do with such link and didn't open new terminal with ssh session.

![OSCP Post](/assets/images/oscp/exc1-10.png)
**Figure 27** Issue to use the SSH link.

So solve this issue we need to troubleshoot our browser, the question we need to ask our self is why, in my case, FireFox didn't know how to open SSH, to find and answer we need to be clear about FireFox. FireFox can loadup FTP url, which is mean that he know how to do so, in that case, we need to find a way to tell FireFox that if the user click on link that contain **ssh://** in that case **please run the following app...**

So our conclusion is that the browser should run an app and execute the command, in that case I going to look at the URL like it is the command, so let's say that our browser know what the app he need to run, my question is how the app does this, i.e. how it takes the URL and converts it to SSH command. so what I came up is the idea to write script in bash to do so. after we will find a way to tell the browser to open the script and run the URL inside it, my script should open an terminal with ssh to the remote machine in my lab.

In my script I know that I need to handle the URL I will get, which going to be something like that:
**ssh://<ipaddress>/**

To make new file I using **touch** and after that I run **vim** to edit this file.

![OSCP Post](/assets/images/oscp/exc1-11.png)
**Figure 28** touch and vim commands.

So I came up with the following script in bash that can help me with the SSH URLs:

![OSCP Post](/assets/images/oscp/exc1-12.png)
**Figure 29** SSH script.
```
#!/bin/bash
url=$1
protocol=${url//:*/}
machine=${url://*:\/\//}
machine=${machine%/}
/usr/bin/gnome-terminal -e "$protocol $machine"
```

In the script we save the URL in the variable url, after that we parse the protocol which going to be the **ssh**, we also parse the machine ip address and remove the slash in the end, after that we open termianl which is the **gnome-terminal** and execute the **"$protocol $machine"** inside of it.

When this will done, an new window of terminal will open up and run ssh to our lab machine. Now we need to make that file executable with the command **chmod**. After that will done, if we run **ls** command it will show us that *ssh-script.sh* is executable file.

![OSCP Post](/assets/images/oscp/exc1-13.png)
**Figure 30** chmod command.

To check if the script working right, we need to run it, we know that the line that our script will handle will be **ssh://172.16.0.180/**, so that what we need to insert that script for checking it, also we use the **./** which call the executable file and run it. When I tried to run it I came a cross some issue with my script.  

![OSCP Post](/assets/images/oscp/exc1-14.png)
**Figure 31** ssh-script.sh doesn't run as expected.

The error tall us that the is an issue with line 4 on our script, so I checked it out and found some miss syntax, on line four was some unnecessary **:**, after I remove it I tried to run the script once again.

![OSCP Post](/assets/images/oscp/exc1-15.png)
**Figure 32** Unnecessary **:**.

![OSCP Post](/assets/images/oscp/exc1-16.png)
**Figure 33**

After that, I check the ssh service status and start it, in my case the ssh  service was on down state,
**Please note:** ssh service used to allow our local machine to act as ssh server, you doesn't need to run it on the ssh client.

![OSCP Post](/assets/images/oscp/exc1-17.png)
**Figure 34** SSH service status.

I tried to check if ssh on local machine are working right, so I run the follow up command on my local machine

![OSCP Post](/assets/images/oscp/exc1-18.png)
**Figure 35** ssh to local machine.

after it work successfully I run the script with the ssh line that going to be on our local webpage and finally it work well.

![OSCP Post](/assets/images/oscp/exc1-19.png)
**Figure 36** ssh is working to my local machine by using the script.

Now, to get the browser work, we need to tell it how he going to execute the script evry time someone click on **ssh://** link, I search over the Internet and found that the setup for such case can be found on the config menu, to get that menu on the brouser search box type **about:config**.

![OSCP Post](/assets/images/oscp/exc1-20.png)
**Figure 37** config menu.

in that config list we need to allow to using ssh and applied it to execute our script in every case someone click it, to do so we need to add new URL Handler, which is **network.protocol-handler.expose.ssh**, the value for that going to be **false**, which going to bring the user a popup dialog to choose application to run the link, ehich is going to be our script.

**Please note:** in my case I wanna to add that setup directly on the FireFox **prefs.js** file, to file where it locate I used the following command:

```
find / -name prefs.js
```

That file was found in my case under mozilla folder, after that I add up that line to the file.

![OSCP Post](/assets/images/oscp/exc1-23.png)
**Figure 38** expose.ssh on the prefs.js file.

After I finish all, it's the time to check if we can use the SSH link to bring up ssh session to our remote lab machine, which in my case is my **zwerd ubuntu**.


![OSCP Post](/assets/images/oscp/exc1-24.gif)
**Figure 39** ssh connection opened up.


**Summary:** Knowing how to operate a computer is very important in the Offensive world, it is important to know just a few areas, to know Linux and Windows, how network protocols work, how to build a website, how to connect from one app to another, and find a way to help us achieve what we want. . Most importantly, if there is something that we do not know how to do, we have tools to find it, such as searching Google, reading articles or guides on the same topic and connecting all the things we need, this is the logic of the world. -Offensive in my opinion, should be a little sophisticated, we will see this logic later, it requires us to be smart and think a few steps ahead to succeed in the intrusion testing mission.

![sql-injection-044.png](/assets/images/sql-injection-044.png)
**Figure 44** GAME OVER.


# Chapter 2 - Get comfortable with Linux

Because we are going to use a lot of Kali Linux it is a good idea to be with strong knowledge using this operating system. And there is nothing like getting to know the operating system as well as you know its command line. The Linux language used in the terminal is **bash** and there are many commands that can help us to do such and other manipulations in the system to get what we want.

## Commands you must to know

There is a lot of linux command line that I used daily, and the following list are what can help you to operate with Kali and get comfortable with it.

**sudo** - sudo it the way for us to run some code on administrator privilege mode which use root user.

**pwd** - will bring you the current directory.

**echo** - used for print thing on the screen, like variable the saved on the memory to check what it their value or such.

**cd** - change directory, you will use this command to change your current directory, in the most cases if you want to get out from some directory to it's upper folder you can run cd **../**, one dot specify the current directory and two dots specify the upper directory, so if you are at **/var/log/** run the **cd..** will take you to /var folder

**mv** - this command help to mv file from one lication to another, and also used for changing file name.

**rm** - remove some file. please note to noe use the command **rm -rf /**, the / alone in the linux world is the root folder which contain everything on your system, so this is why that command are dangers.

[![OSCP Post](https://vangogh.teespring.com/v3/image/0nKMdAhpyAR8FA56MjCnK-UUXFE/480/560.jpg)](https://teespring.com/linux-dont-drink-and-root-tshi "Buy This TSHIRT")
**Figure 40** Don't drink and drive.

**mkdir** - create new folder.

**cat** - print all of the file contents on the screen.

**more** - the same as cat but with more you can control the view speed, and read line by line.

**head** - print the first line of file on the screen.

**grep** - search for specific string, if you run cat on some file and want only to see every line that contain **machine** word, then grep can help you, you just need to pip it and write what you wanna search.

```
cat /var/sys/file.log | grep '2019/04'
```

**wget** - this command is non-interactive network downloader which means that we can use this command to download something from the Internet on the command line.

**cat** - used for cut a part of string, display it or display the string without the cuted part.

**sort** - used for sort some list we want to display.

**uniq** - display multiple string that repeat it self as uniq with a number of how many times this been repeated.

**man** - if you ever need to know how some command work and what is the option for this command, you can check it with man page.

## Script with bash

As you are supposed to know so far, the commands I have presented are used in bash language, which means that if we write some script there is a mode that we will use one of these commands.

When talking about scripts we often use repetitive things, that is, if you know Python or JavaScript it already gives you a good basis for programming language in general and scripting language in particular, the principles are repeated in every language, only that each language has its uniqueness and each language usually brings A logical part that is not found in another language, after all that is the reason why there are so many languages.

If you have already programmed in the past, you probably know what Boolean value is, what is function, if & else queries, loops and many other repetitive things in programming languages, if you do not know then there is nothing to stress, it means it is time to learn and if you have already started Linux, then enter the bash world.

I think the best way to learn about bash is to read some articles or watch a video on the subject and then do some challenges to help you get better and understand how it really works, a site I can recommend is [hackerrank](https://www.hackerrank.com/domains/shell), where you can find interesting challenges.

If you have completed a number of challenges and returned here to move forward or if you already know how to write your own scripts, let's see how it can be used to find information, or even sensitive information that we can later use to perform some action as part of an intrusion test.

Let's say we want information from the CheckPoint site, and we want to take out all the links or URLs that appear on their main page, convert them to addresses, and print those IP's on the screen with a display on each address how many times it repeats.

The first step is to use wget to get the index.html of CheckPoint site.

```
wget www.checkpoint.com
```

On the current directory we will find new index.html file that we going to manipulate and use grep to get out the information that we need from that file.

```
grep "href=" index.html
```

![OSCP Post](/assets/images/oscp/grephref.png)
**Figure 41** grep the href.

Now we want to take every line that contain href and display only the like that specify, to do so we can use href.

```
grep "href=" index.html | cut -d "/" -f 3
```

![OSCP Post](/assets/images/oscp/grepwithcut.png)
**Figure 42** grep with cut.

The problem so far is that we can get on our list unwanted string like as follow:
```
leadership
investor-relations
">Press Releases<
news-coverage
careers.checkpoint.com
contact-us
www.facebook.com
twitter.com
www.linkedin.com
goo.gl
">Copyright<
privacy
a><br>
```

So we need only domain name, to do so we going to use grep again for print out only string that contain dot **.**.

```
grep "href=" index.html | cut -d "/" -f 3 | grep "\."
```

![OSCP Post](/assets/images/oscp/grepagain.png)
**Figure 43** grep the dot from the list.

The issue we have now is that we have some line that contain chars like **>** and so. What we knew that every href link ended up with quotation marks, so we can use it to cut out that string. We also want to sort it by Alpha beta.

```
grep "href=" index.html | cut -d "/" -f 3 | grep "\." | cut -d '"' -f 1 | sort -u
```
![OSCP Post](/assets/images/oscp/sortthelist.png)
**Figure 44** sort all.

Now we wanna to to check every domain address what is his IP address, first of all becouse we wnat at the end to view how much address repeat itself - this is why I remove sort. I direct the output to file named list.txt, and after that we will manipulate that file to get the IP's of every domain.

![OSCP Post](/assets/images/oscp/redirect.png)
**Figure 45** Redirect the output to list file.

Now it's time to find the IP's of each domain, I'm going to use bash script with for loop that check out every domain name and that check with the **host** command what is the address.

![OSCP Post](/assets/images/oscp/forloop.png)
**Figure 46** For loop.

After I have list of address, I want to see only IPv4 address, so now I am going to use grep again and pull out only the addresses I needed with cut command. Also I will check uniqueness on this list and check out how many time every address repeat itself.

![OSCP Post](/assets/images/oscp/forloop2.png)
**Figure 47** For loop with other bash commands.

**Summary:** It is important to know how to work with the bash command line and get to know its environment. Writing scripts can greatly help before or during an penetration test, such as preparing a work plan that will include some pre-built scripts that should help us obtain certain information or manipulate a network that will in some way Users take involuntary actions so that we can obtain confidential or sensitive information.
