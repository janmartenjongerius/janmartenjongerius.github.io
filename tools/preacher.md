# Preaching to the world

During my 100th attempt to start a developer blog, I looked around for a good
solution to set up a nice and clean personal site, without having to think about
maintenance. Given that being a developer is my day job, in my spare time I do
not intend to maintain some elaborate hosting setup that requires my constant
attention, in this world filled with security risks.

As you might have noticed by now, I like to ramble on, so it is clear I need to
focus my time on becoming a better writer than fine tuning my skills as a
website hoster.

As I've known for a couple of years, I wanted to set up a static website, just
to keep the focus on writing and styling my website. Even though I'm really
passionate at backend development and software architecture, a small child in me
likes to fiddle around with the latest features in front end land.
That being said, on a professional level, I've done this and all around me know
that I hate supporting old browsers and all those new mobile devices, wearables
and tablets, with a passion.

Oh, see, we're getting so much off track already. This is what happens each time
I try to start a blog. One of my previous attempts ended up in a validation
suite, called [HylianShield](hylianshield.html).
Because, you know, I ended up writing a custom template engine and of course
that required validation and of course I had to write my own solution for that.

So, back to blogging software. Let's not keep distracted by every possible tangent.

I was unsure if I wanted a personal website or a personal blog. The difference
being that the one is merely meant for writing articles, whereas the other allows
to support less structured pages. After having a small debate with my inner
voices, I concluded that a personal site would be best.

The following criteria must be met:
* Support for custom pages
* Support for a blog
* Must be able to show syntax highlighted code
* Requires no hosting maintenance / any custom web stack
* Must not require to be hosted on a shared hosting solution
* Allows freedom to maintain custom themes per page
* Requires no knowledge of configuration of any kind
* Leverages meta information, like the author, date, version, number of revisions
  and information to create canonical URLs.
* Must be written in a language that I already know and have installed on my
  workstation.

The following things would be nice to haves:
* Content can be written in Markdown. Preferably GitHub Flavored Markdown.
* Templates can be written in Twig.
* Hosting can be done using GitHub pages.
* Meta information is extracted from the local GIT repository.
* It can automatically generate static files without using builder software like
  Grunt, Gulp, Bower or any of those fancy tools that watch your files.

I had a look at existing free blogging tools for developers. Solutions like Jekyll
and Couscous were great contenders, but they both failed on the configuration
requirement and Jekyll is written in Ruby, which is fine, but requires me to
install additional software, which conflicts with my requirements.

So, once more, I set out to writing my own software, but this time with concrete
criteria. I created [Preacher](https://github.com/ZeroConfig/Preacher). It
allows me to maintain this very website.

* Preacher requires zero configuration
* It can run as a post-commit hook in GIT
* META data is extracted from the local GIT commits
* Content is written in Github Flavored Markdown and thus supports syntax
  highlighting
* Templates are written in Twig
* File structure is identical to that of the Markdown files
* It is agnostic of hosting and its settings
* PHP is its programming language
* All components are coupled using interfaces, so every component can be swapped
  out with other technology
* It only generates output if either the source file (Markdown) or template (Twig)
  has been altered
* It supports custom templates per page and falls back to a default

It took me about a day to write this, and some more time to give it a full code
coverage with unit tests, deploying a working `1.0.0` version in just a weekend.

Preacher is open source and features are always welcome. I'm thinking about
allowing for a plugin ecosystem, but for now it does its job. And that's
something I also very much like about Preacher. It does one thing and it does it
really well. In this case it connects existing software and relays their output
from one end to the other. It tries to NOT be smart wherever and whenever it can.

For the person still reading this, I hope I have inspired you to think for
yourself and see if the solutions that are out there are really for you, or just
the defacto solution. There is a lot to say for using a defacto solution, but I
strongly believe tools are there to help you, not to define what you write and
what you develop. As such, Preacher does elevate well maintained and standardized
software, even though it is a new iteration upon many existing solutions.

Be a proud developer. Don't let arguments like: "This already exists" stop you
from developing your own software. Because even if it did not enrich the entire
community, at least you had fun developing and probably learned something new.

Keep fun a part of your life :)
