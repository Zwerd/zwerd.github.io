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
- [Design your app icons & view](#design-your-app-icons-&-view)
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
