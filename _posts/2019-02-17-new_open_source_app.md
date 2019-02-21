---
layout: post
title: MyGmach - My New Open Source App (react native app)
excerpt: "At last I finish another application using React Native for native mobile apps using JavaScript and React, the first one was NachRiddles which is base on my dear brother's book. MyGmach app is build base on my father idea. Every Saturday my dear brother used to wear a certain tie that was unique to the parsha on that Shabbat. After he passed, my father wanted to open Gmach - which is the way in the Jewish world to help each other without getting paid (in Hebrew it is an acronym for kindness which is pronounced Gemilot Hassadim ['גמילות חסדים'])...  "
tags:
- React-Native

---

At last I finish another application using React Native for native mobile apps using JavaScript and React, the first one was NachRiddles which is base on my dear brother's book. MyGmach app is build base on my father idea. Every Saturday my dear brother used to wear a certain tie that was unique to the parsha on that Shabbat. After he passed, my father wanted to open tie Gmach - which is the way in the Jewish world to help each other without getting paid (in Hebrew it is an acronym for kindness which is pronounced Gemilot Hassadim ['גמילות חסדים']), and give anyone tie as needed.

After my father told me about is idea, I start to work on MyGmach to build an application that allow to manage privet foundation with items in it, so i wrote document about the functionality that I want to build in that application.

In this post I am going to describe the long way I done to build the MyGmach app.
- [Writing your documentation](#writing-your-documentation)
- [Design your app icons and view](#design-your-app-icons-and-view)
- [Start building your app](#start-building-your-app)
- [Changing during building](#changing-during-building)
- [Code review](#code-review)

## Writing your documentation
The most thing that is very important before you start to write your app is to write documentation about your idea and describe it in details with the following guide line:
- What problem or issue the app trying to solve
- What functionality the app will provide
- What is the target audience

After you will answer this questions, it will be very simple to build the app. In my case I had to write what I told you in the beginning of this post, and I describe every detail that I found important to decide what I want to achieve with that app. I must confess that I also wanted to improved my JavaScript skills alone the way, but the most important thing is go through the idea that base on my dear brother's ties.

### What problem or issue the app trying to solve

In my case I tried to build smart management way to every privet person that have charity or foundation with items to deliver other without getting paid, I search over the net and found some app that do something that  is similar to our idea, some of the app can organized objects and others can managing objects, one of the apps is **borrow-it**, but this app focus on way that people borrow stuff to each other and getting paid, another disadvantage of borrow-it is that this app is available only on app store, that mean that only person with apple device can use this app. Eventually none of those app doesn't offers what I want to get and allow people to do that can be helping each others.

So lets think about our goal, in mine set we want get some manageable app for items in foundation (which is the 'Gmach'), we want a way to allow users to create foundation and add items to it, and later on, we want that the user will have the ability to deliver items to people who want to borrow it (LOL) and save the details about the borrow one in the app. After we have the details about that person we want some more things to achieve:
1. Connect with the borrow person,
2. Save the date the object or items has being borrowed.
3. Save the date that person will must to give back the borrowed stuff and returned it.
4. Save the history of borrowing the item (for personal use in the future)
5. Make some easy way to know what object is available on the foundation and what is not.
6. Numbering each object and summarize it.

After we have all that information, it can be great start for our document.

### What functionality the app will provide

As we all know, apps that build under the category business, will provides some function the allow the user to find items more quickly, edit items, delete items etc. In this section of the document we must decide what functionality we want to build to make our app more friendly.

so let's write down the functionalities:
1. Allow user to add foundations
2. Allow user to delete foundations
3. Allow user to edit foundations
4. Allow user to enter the foundation
5. Allow user add items in the foundation
6. Allow user delete items
7. Allow user edit items
8. Allow user to search function
9. Allow user to search item in function
10. Allow user to save borrow personal detail under the item he/she borrowed.
  10.1 Full names
  10.2 Address details
  10.3 Phone number
  10.4 Date of borrowing
  10.5 Date of returning the item
11. Allow user to call the person
12. Allow user to text SMS to the person
13. Allow user to open Whatsapp to the person number
14. Allow user change font size
15. Allow user to setup alerts

Keep in mined that maybe as long as the developing will take you may find yourself thinking on another functionality that you want to insert to your app. the document need to be guideline and no else. it will help you to achieve your goals more quickly because every functionality is writing down and you know what you need to do, the only question is how to achieve your goals which mean, how to develops that functions. but if on the way you have some another idea, you can applied it to you app. another thing is the way you develop, maybe you will face with some challenge of setting one of our function and to solved it you may found some creative idea and setup another functionality that doesn't write down in this document. It's ok to do so, in my case I found my self without document, working on some not so clear idea, and in this situation it's was difficult to me to start develop it! I set on my desk like five days without progress only because I didn't figure it out how I am going to implement my app. so keep all this in mined set, you must to make required document about your app to make things progress mote easily

You can also to describe every page on the app, what function will be in what page, how the page will be connect to each other, and some guide line about the view or icons. It's ok if you trying during the developing to change one or more goals but again, writing it down will help you in the building the pieces.

### What is the target audience

it's maybe not so important, but if you know what is your target audience it's help you to make the app fit to your audience. as example , if you develop some game the audience is more likely to be children or gamers, so you may know that your app must be whit high graphics and lots of colors to make the app desirable to install and use it. it your app build to help the old generation to do stuff, you for sure know that you must to develop the  app in the way it will be more accessible and easy to use.

In my case the app will need to served the middle and old age people, so it must be simple, easy to use, clarify what every button would done, and bring more useful data to the users.

After you finish the document, you can set your chair back down and be proud of your self. no, we doesn't finish our mission but it is a big progress in our project! now we can jump ahead to the fun stuff :)

## Design your app icons and view

Design is also big part, in this part we need to chose colors, icons and main app icon, and of course design the pages of our app. you can design the app on some notebook which is what I have done, but you also can design it using some design program like photoshop (there is no better way to do so) or some build in drawing software on your PC, like LiberOffice drawing on Linux or VISO on Windows.

Lat's parted the design stuff to more small pieces:
1. Main icon
2. A standard icons
3. A standard colors and view style

### Main icon

In my case, the app, as I already said, base on kindness to each other, this is mean the people who usually going to use this app will give something to other, so in my imagination the app icon need to be base on giving each, and what best describe that image? two hands that holding each other or give something to each other.

The first icon that I design was base on heart that have red, yellow and pink colors and two hands that look like they trying to reach each other (or one hand trying to help another).

![MyGemach-01.png](/assets/images/MyGemach-01.png)
**Figure 1** My first icon.

The second one was a simple circle with blue colors and background that base on symbols from the Jewish world with same two hands and charity box.

![MyGemach-02.png](/assets/images/MyGemach-02.png)
**Figure 2** My second icon.

The last icon and the one that I chose eventually to be the symbol for this app is more simple circle with blue colors and two hand holding each other and making figure of heart together. This is the best icon that I can thinking about for this app. I proud!

![MyGemach-03.png](/assets/images/MyGemach-03.png)
**Figure 3** The app symbol.

### A standard icons

What I mean by say standard is the icons for every button in the app. We want to make the app with unique style and save this style to be the same on every page in the our app. In my case the app symble is already with a certain shade of blue, to be exact it's with `rgb(0,176,240)` or `#00B0F0`. So I use this color in every icon that I made, the ideal is to make it simple, so every button on my app is round blue circle with icon in the middle that figure the action that button will make. As example the delete icon is big white`X` in the middle of the circle.

![MyGemach-04.png](/assets/images/MyGemach-04.png)
**Figure 4** Delete button.

Other button is the edit, this icon is the same as the last one with blue round circle and the symbol in the center is white pencil.

![MyGemach-05.png](/assets/images/MyGemach-05.png)
**Figure 5** Edit button.

So every button should be look the same as I describe, same round blue circle with symbol at the center.

![MyGemach-06.png](/assets/images/MyGemach-06.bmp)
**Figure 6** My app icons.

### A standard colors and view style

As I said earlier, the color is certain shade of blue, for the word in the subtitle I used NARKIS font, and the other is always Ariel. the color of underlines are gray, and every window that popup are white with button of some word like 'approved' or 'cancel' that have a style of round adges (radius set on 25).

Every page must have a blue headline with the button icons and endline of the button of the screen. the ideal is to use mainly blue colors with white.

![MyGemach-07.jpeg](/assets/images/MyGemach-07.jpeg)
**Figure 7** Some page.

I setup the status bar to be blue also because I wanted to keep consistency. The background on every page is (if you remember) base on the same idea that I have on my second symbol for this app.

Every page that have list of items, the item itself will be white and with border width of 1 mm, the words will be display in black color and the picture radius will be set to 2 on every item that the user will create as you can see in *figure 7*.
