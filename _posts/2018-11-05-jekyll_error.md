---
layout: post
title: Jekyll Error - `block in materialize'
categories: [Development, Github Pages]
tag: [Jekyll] 
---

As you may know, this site is build using Jekyll, that help me to done all the magic automatically which is great. In the passed week I reinstall Ubuntu on my laptop and that forced me to use git again and clone the project from my repository and after I install gem I tried to run Jekyll but goat some error, so I I wasted an hour on it and after I fund the fixing for that I decided to share is here.

So, the first thing I done is to go throughout the Jekyll documentations and install it using the following commands:<br>
```
sudo apt-get install ruby ruby-dev build-essential
```
I'm using zshell, so in my case I'm using `/.zshrc` instead of `/.bashrc`:
```
echo '# Install Ruby Gems to ~/gems' >> ~/.zshrc\necho 'export GEM_HOME=$HOME/gems' >> ~/.zshrc\necho 'export PATH=$HOME/gems/bin:$PATH' >> ~/.zshrc\nsource ~/.zshrc
```
after that using the last command using gem:
```
gem install jekyll bundler
```
I was so happy that so far I doesn't received any error, but it was too early to party, when I run the command `jekyll serve` the first error appear:

![jekyll-error_error_jekyll-3.8.1.png](/assets/images/jekyll-error_error_jekyll-3.8.1.png)
**Figure 1** tjekyll 3.8.1 is missing.

Than of course I run the command:
```
gem install jekyll --version 3.8.1
```
After that I tried to run the `jekyll serve` again, but still received an error, little bit different, but still doesn't get it to work right.

![jekyll-error_error_jekyll-feed.png](/assets/images/jekyll-error_error_jekyll-feed.png)
**Figure 2** jekyll-feed 0.9.3 is missing.

I can right now to do the same and install `jekyll-feed 0.9.3` but I rather not to because I don't want to go throughout every gem and install is manually, so I googled it and found that I need to run `bundle`:
![jekyll-error_bundle.png](/assets/images/jekyll-error_bundle.png)
**Figure 3** Run the bundle command.

Now I run again the `jekyll serve` but I received the another error:
![jekyll-error_check_for_activated_spec.png](/assets/images/jekyll-error_check_for_activated_spec.png)
**Figure 4** check_for_activated_spec error.

So I go through `bundle exec jekyll serve`:
![jekyll-error_bundle_exec.png](/assets/images/jekyll-error_bundle_exec.png)
**Figure 5** bundle exec jekyll serve.

And that it! working like charm.

<audio controls="controls">
  <source src="https://docs.google.com/uc?export=download&id=0B5Js_4pfB8j3TEhxTVhYTmhreWhZZFRUdTRZR1RNYkRHMXBj">
</audio>
