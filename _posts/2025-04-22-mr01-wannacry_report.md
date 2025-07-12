---
layout: post
title: MR01 WannaCry Kill Switch Report.
categories: [Tutorials, Reports]
tag: [Malware Analysis , Network Traffic Analysis, Malware Research] 
---

# General 

![003.jpeg](/assets/images/malware-analysis/Aspose.Words.e39fe440-01ef-47b9-8fa2-5ff88860777d.003.jpeg)

**MR01 - WannaCry Report** 

**Date: 22/04/2025 \
Written by: Guy Zwerdling** 

<a name="_page2_x33.00_y78.92"></a>**MR01: WannaCry**  

<a name="_page2_x33.00_y107.92"></a>**Executive Summary** 

WannaCry is a ransomware that locks files on Windows computers and tries to spread to other machines. A key part of how it works is a built-in "kill switch", a strange-looking website address it checks when it runs. If the malware can reach this website, it shuts itself down and does nothing. This was likely added to make it harder to analyze the malware, but once a researcher found and registered the domain, it accidentally stopped WannaCry from spreading further. 
