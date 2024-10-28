---
layout: post
title: Automating Letter Counting for Tombstone Engravings, A Meaningful Project.
categories: [Development, JavaScript]
tag: [JavaScript] 
---


## A Unique Connection

In my journey of learning about Judaism, I have been fortunate to spend time in the synagogue, where I prayed and engaged in discussions with my rabbi. His deep understanding of the faith and life experiences have profoundly influenced me. What particularly struck me was his unique background as a former grave digger who now crafts tombstones. His current work is not just a job; it is a calling that honors the memories of those who have passed.

As I listened to him share his stories and the responsibilities that come with creating tombstones, I became aware of a significant challenge he faced. The process of counting letters for engravings on tombstones can be quite tedious, especially when inscriptions can amount to several hundred characters. Each letter incurs a specific cost, so accuracy in counting is crucial.

## The Challenge Unfolds

The rabbi explained to me that many clients request elaborate engravings, often filled with names, dates, and heartfelt messages. However, counting these letters manually can be overwhelming, especially when distractions abound or the volume of work is high. It became clear to me that there was a way to streamline this process—an opportunity to use technology to make a meaningful impact on his work.

## The Idea Takes Shape

Inspired by our conversation, I proposed developing an online tool that would automate the letter-counting process. This would allow the rabbi to simply upload a document and receive a quick count of the letters, making it easier for him to provide accurate pricing for his clients. The rabbi was intrigued and agreed that this could be a valuable asset.

## Selecting the Right Technology

With the idea in place, I began to think about the best technology to use. The key requirements were accessibility and ease of use. The rabbi needed a solution that could work on his smartphone, laptop, or any device he might have on hand.

I considered several options:

- **React Native**: While powerful for creating mobile applications, it seemed too complex for a task this straightforward and would delay deployment.

- **Python**: This language is excellent for server-side applications, but I didn’t have an online server to host the tool.

- **PHP**: Similar to Python, PHP requires a server environment, which was not feasible for our needs.

After weighing these options, I concluded that JavaScript was the ideal choice. Running directly in the browser, it would enable the rabbi to access the tool from any device without needing server support.

## Choosing the Document Type

We also discussed which document type would work best for the tool. The rabbi mentioned that PDF files were commonly used for client submissions. After considering this, we decided that PDF would be the perfect format, given its widespread use and compatibility across various platforms.

## Crafting the Solution

With the technical details settled, I dove into coding the solution. I focused on creating a user-friendly interface that would allow the rabbi to easily upload a PDF document. One crucial aspect of this project was ensuring that the letter count would ignore specific characters that the rabbi identified, including `. , - _ ' `. This feature was essential to provide an accurate count that aligned with the pricing structure for engravings.

After several iterations, testing, and refinements, I finally completed the letter-counting tool. The application runs entirely on the client side, meaning it can be accessed on any device with an internet browser. This versatility would allow the rabbi to count letters on the go, whether he was in his workshop or out meeting clients.

## The Final Product

The result of our collaboration can be found here: [PDF Letter Counter](https://zwerd.github.io/scripts/pdfcounter.html). With this tool, the rabbi can easily upload a PDF and receive an instant letter count, which will significantly enhance his workflow. No longer burdened by the tedious task of manual counting, he can focus more on the artistry of his work and the meaningful connections he builds with his clients.

## Reflecting on the Experience

Working on this project was more than just a technical endeavor; it was a deeply fulfilling experience that allowed me to contribute to something significant. I witnessed firsthand how technology could play a role in preserving memories and honoring the lives of those who have passed. It reinforced my belief that even small innovations can have a profound impact.

The rabbi's gratitude for the tool has been heartwarming, and it feels good to know that my skills could help him in such a meaningful way. This project has not only strengthened my connection with him but has also deepened my understanding of the values embedded in Jewish traditions surrounding remembrance and honor.

## Conclusion

In the end, I am grateful for the opportunity to work on this project and for the lessons I learned along the way. It serves as a reminder that our skills can be used to uplift others and make their work easier. If you’re interested in similar projects or have any questions about the code, please don’t hesitate to reach out. Together, we can find ways to innovate and support the important work of honoring our loved ones.
