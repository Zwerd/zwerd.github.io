---
layout: post
title: Linux Ubuntu
categories: [Tutorials, Linux]
tag: [Linux] 
---

I love so much ubuntu because it so frendly lol, but realy, the reasens in my opinion why to used Ubuntu is because of the communities that support in ubuntu, it's important to understand that the biger the community, the better support, anless u wanna to be hard core in linux and that another immportant field

In the passed week I worked on my grub, this is grub 2 and I setup some opening image, it was so cool after that I decided to setup opening music, so I configure the Hz of "In the Hall of Mountain King". It sound great, to setup your own music sound all you need is to open /etc/default/grub file and in the section of GRUB_INIT_TUNE write your own code, the first number is the tempo, and after that the nubers goes as a peers the first one is the Hz tune and the second is the delay of the tune, as example:
```
GRUB_INIT_TUNE="412 265 4 165 4 265 8"
```
the first number "412" is the tempo that we going to work with, the second number is the tune of "265 Hz", the last number is "4" and this is set the sound delay, so number "8" is two time longer than "4"

It's impossible not to mention this piece called In the Hall of the Mountain King, which is from Grieg's Per Gynt, which everyone knows because it starts out terribly quiet and slow, and then slowly it accelerates and becomes insanely loud and fast until it sounds like a musical heart attack. And it's really suitable for those who want to start the morning with atomic pressure because hearing it on a physical speaker is a dubious experience, especially when the beeps start running fast and it sounds like a robot panicking, but I still sat down and wrote the sequence of numbers for it, so here's my code for this thing:
```
GRUB_INIT_TUNE="714 123 4 138 4 146 4 164 4 185 4 146 4 185 8 174 4 138 4 174 8 164 4 130 4 164 8 123 4 138 4 146 4 164 4 185 4 146 4 185 4 246 4 220 4 185 4 146 4 185 4 220 8"
```

please remember that after you setup the grub you mast type the command "update-grub" for the setting will take affects
more cool song to the grub:

And speaking of computer beeps, it's impossible not to remember the annoying Super Mario melody that gets stuck in your head forever, which is pretty amazing considering that the game came out sometime in 1985, which is a long time ago, and it even came out in a version for that fat, gray Game Boy. But today, in the modern era, when we have powerful Windows computers, no one is looking for tapes anymore, but simply downloads all kinds of software called emulators, such as fceux or similar things that run everything easily. And this is actually the most convenient solution because the old hardware no longer works and is just gathering dust at home:

```
GRUB_INIT_TUNE="1000 334 1 334 1 0 1 334 1 0 1 261 1 334 1 0 1 392 2 0 4 196 2"
```

Another strong piece is the Star Wars melody, the Imperial Death March, which everyone immediately thinks of Darth Vader entering the room with the cloak, and it's a piece that first appeared in the movie The Empire Strikes Back in 1980, and it's simply a classic that can't be ignored. And it's pretty funny to try to take such a bombastic piece that John Williams wrote for a huge orchestra with trumpets and drums and convert it into a series of annoying beeps on the computer's internal speaker that sound like a sick robot instead of a philharmonic orchestra. But there's nothing you can do about it. You just have to set it in GRUB_INIT_TUNE with all the frequencies and weights so that every time you turn on the computer, you feel like you're inside the Death Star for a moment before returning to the boring reality of the operating system:
```
GRUB_INIT_TUNE="480 440 4 440 4 440 4 349 3 523 1 440 4 349 3 523 1 440 8 659 4 659 4 659 4 698 3 523 1 415 4 349 3 523 1 440 8"
```

And while we're on the subject of heavy music, we can't help but mention Slayer's "Raining Blood," a song released in 1986 on the album "Rain in Blood," which is considered a classic of thrash metal with all the fast riffs and crazy drums that it's a miracle to even try to transfer it to a crappy physical speaker. And it's just laughable to think that you can take all that aggression and reduce it to a series of monophonic beeps that sound like a broken Atari game, but people actually sat down and wrote the frequencies of it so that you could put it in GRUB, and every time your computer boots up, you hear that famous opening only in the form of an annoying beep that makes you wonder why you did it to yourself in the first place:
```
GRUB_INIT_TUNE="640 165 4 165 4 165 4 554 2 587 2 554 4 370 2 554 2 523 4 349 2 523 2 494 8 165 4 165 4 165 4"
```
And let's not forget that cute little sound of the mushroom that you take and grow, which is the famous Powerup, which is a great thing to put in GRUB because it's short and to the point and you don't have to wait an hour for the melody to end for the computer to boot up, and it just makes a cool rising sound for a few seconds that reminds you of oblivion. And it's actually better than all the long, boring melodies because in the end, we just want to turn on the computer and see that everything works, not hear entire concerts through that rattling internal speaker that only gives us a headache:
```
GRUB_INIT_TUNE="1750 523 1 392 1 523 1 659 1 784 1 1047 1 784 1 415 1 523 1 622 1 831 1 622 1 831 1 1046 1 1244 1 1661 1 1244 1 466 1 587 1 698 1 932 1 1195 1 1397 1 1865 1 1397 1"
```

And there's also this piece by Beethoven called La Elise or by its professional name Bagatelle No. 25 in A minor, which is a terribly bombastic name for a melody that everyone knows as the music of the ice cream truck or the waiting on the phone when you call the health insurance company, which is the most annoying and annoying thing in the world. And it's actually quite funny to take such a respectable classical piece that was intended for piano and turn it into a series of harsh beeps in GRUB that sound like a greeting card from a musician whose battery has run out, and it gives the feeling that the computer is trying to be civilized and intellectual, but in reality it's just beeping at you in a monotonous way until you remember why Beethoven was deaf and realize that maybe it would have been better to leave the computer on silent and that's it:
```
GRUB_INIT_TUNE="480 420 1 400 1 420 1 400 1 420 1 315 1 370 1 335 1 282 3 180 1 215 1 282 1 315 3 213 1 262 1 315 1 335 3 213 1 420 1 400 1 420 1 400 1 420 1 315 1 370 1 335 1 282 3 180 1 215 1 282 1 315 3 213 1 330 1 315 1 282 3"
```

So, from this lines you can setup the favorit song you like, and another things you should be knowing about that GRUB2, that only after the song is finish to sing, only then the GRUB2 menu will showed up, befor it, you may see just black screen, so this is meaningness that if you setup long bip song, it wait on blck screen untile the song is came to the end.
another thing you can set is the background of the GRUB2 menu, in my case it just green picture that I liket to set on that menu, but you can run search on google to get know for more butifall images


Another thing you can consider is the security way in the grub2, it can contain password needed for see the contect but I will now explain it here, just be ware that there is some options that can be used for make it better

And speaking of things that don't work properly, we have to mention GRUB2, which is a story in itself, because once in the old version there was a simple menu.lst file that could be edited with fun, but now they decided that wasn't good enough and made an entire system that automatically builds the config file that you shouldn't touch and it says in capital letters DO NOT EDIT THIS FILE, which is the most stressful thing there is, and you have to go to another folder in etc and edit files there, then run the update-grub command and hope for the best that it doesn't overwrite something important in the MBR or EFI partition, and it's just a long and cumbersome process to change some poor timer from 10 seconds to 5 seconds, and no one has the strength to wait for them anyway.

And in addition to all these troubles, there's the issue of the resolution of the menu itself, which never matches the screen properly, and you have to start playing with the GRUB_GFXMODE in the default file and guessing resolutions that the BIOS supports via vbeinfo, which is a command that you have to run inside the grub shell, which is a scary black screen that looks like DOS from the eighties, and in the end everything comes out pixelated or the font is too small and you can't read anything, and that purple Ubuntu background image has already come out of all the holes, but replacing it is another unnecessary project that I don't intend to get into now.
