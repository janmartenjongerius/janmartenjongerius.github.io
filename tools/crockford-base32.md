# Crockford's Base 32

As a developer with aspiration for greater insights and experiences, I look up
to a number of more senior people in the branch.

One, in particular, I keep tabs on, regularly. He has a great mind and comes up
with the best solutions, often before people know they want it.

This article describes how I
[implemented](https://github.com/hylianshield/base32-crockford)
the Base 32 specification, designed by
[Douglas Crockford](http://www.crockford.com).

Douglas created an implementation that allows for an alphabet which can error
correct itself to a certain degree. He would have a user be able to say out loud
an encoded string, on the phone, and have it decoded correctly, even if the other
person on the phone receives the characters incorrectly or inputs them incorrectly.

Basically, he's allowing the human species to do what they're really good at.
Obscure input and data and still expect a sensible result.

![Simple answers](https://imgs.xkcd.com/comics/simple_answers.png)

> 'Will [     ] allow us to better understand each other and thus make war
undesirable?' is one that pops up whenever we invent a new communication medium.

"What kind of magic is this?" - you might wonder. I wondered just about the same
thing and with ample intrigue I spent some time reading and interpreting
[his specification](http://www.crockford.com/wrmg/base32.html).

Based on a number of principles, he creates an alphabet with the following in mind:

- Letters that allow the forming of offensive words should be left out.
- There are 32 characters in which a value can be encoded, which are all uppercase
  letters and the numbers 0 through 9.
- When decoding, both the lowercase and uppercase version can be used to resolve
  to the same value.
- The letters `i` `I` `l` and `L` look too much like the number `1`, so they are left out
  from the alphabet and instead all resolve to `1` as well.
- The letters `o` and `O` look too much like the number `0` and as such are
  excluded from the alphabet, to be interpreted as the number `0` when they are
  inputted.
  
Since this form of encoding allows the encoding and decoding of numbers, his
optional check symbol is really simple and still fairly ingenious. 

> An application may append a check symbol to a symbol string. This check symbol
can be used to detect wrong-symbol and transposed-symbol errors.
This allows for detecting transmission and entry errors early and inexpensively.

> The check symbol encodes the number modulo 37, 37 being the least prime number
greater than 32. We introduce 5 additional symbols that are used only for
encoding or decoding the check symbol.

> The additional symbols were selected to not be confused with punctuation or
with URL formatting.

The additional check symbols being `*`, `~`, `$`, `=`, and `U`. Of course, since
a user can also input `u` instead of `U`, both are accepted.

Two aspects one can find in base encoded specifications still remain. The padding
and partitioning of encoded strings. Both allowing an increased readability, in
this specification.

The partitioning symbol is set to `-` (dash) and is allowed at any arbitrary
position in the encoded string. The padding symbol is set to `0`, which is also
part of the alphabet, so yay for headaches during development.

But all in all, the alphabet is really clean and does make for a nice to read
encoded string.

Now, I was left with two questions:

1. Will the notation read from left to right or from right to left?
2. If the check symbol is appended, can I assume that it is appended on the
  right-most position of the string?
  
I decided that it was a good assumption to read from right to left and having a
check symbol appended on the end of the string, thus placing the padding symbols
on the left side of the string.

So I went and developed that, but it didn't feel right. There was no way for me
to validate my assumptions. The specification was not 100% ambiguous on this, as
it does not define how the encoded value is calculated.

So... no way to be sure... or was there? I went for a shot in the dark, gathered
some courage and wrote the following e-mail. Remember that to me, this is the
same as writing to a rock star:

> Hello Mr. Crockford,
> 
> My name is Jan-Marten. I'm a developer and have written an implementation of
> your Base 32 specification in PHP. (http://www.crockford.com/wrmg/base32.html)
> 
> > https://github.com/HylianShield/base32-crockford
> 
> During development, I struggled to find a sensible way to represent numeric
> values with the supplied alphabet, since the specification does not dictate
> how the encoded value is built.
>  
> Using the following, I derived what seemed the most logical representation:
> If the bit-length of the number to be encoded is not a multiple of 5 bits,
> then zero-extend the number to make its bit-length a multiple of 5.
> An application may append a check symbol to a symbol string.
> Since appending the check symbol, by my assumption, would place it on the
> right-most location of the encoded string, the zero-padding would go on the
> left side of the string, making the notation read from right to left.
> This is consistent with BIT-notations when they increase in size.
> 
> However, this is an assumption on my part. I have seen multiple implementations
> of this specification in different languages, each to their own degree of success.
> However, the fear is that they become incompatible so long as the specification
> is unclear about this.
> 
> If you are open to communication regarding this subject, I would like to hear
> your thoughts on this. The specification as-is is beautiful and in my opinion
> highly underappreciated.
> 
> Sincerely,
> 
> Jan-Marten de Boer
> An admirer of your work

I thought something like: "Well, that never gets any reply."

But sure enough, just a couple of hours later, I get back a reply. And with great
joy could he confirm my assumptions:

> Your reading is correct.

And with this, I am a content developer.

Have you ever got the chance to get in touch with your hero? If so, I hope you
had a great experience. Just remember that we're all just people. Which means
that you treat people with respect, give them the privacy they deserve and
maybe, just maybe, you'll get lucky and find they actually take the time to give
you a look, shake your hand, have a chat with you or read your email and send a
reply.

Also, we have a Base 32 encoder, which is user friendly, in PHP, which I think is
pretty cool.
