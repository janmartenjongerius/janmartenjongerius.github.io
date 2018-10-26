# Gold plating the FizzBuzz challenge in PHP

I read a post on Reddit from someone having done the FizzBuzz challenge in PHP:

<blockquote class="reddit-card" data-card-created="1540548025">
    <a href="https://www.reddit.com/r/PHP/comments/9pa8hg/i_did_the_fizzbuzz_challenge_in_php_i_am_very_new/">
        I did the FizzBuzz challenge in PHP. I am very new to PHP, how can I improve my code?
    </a>
    from <a href="http://www.reddit.com/r/PHP">r/PHP</a>
</blockquote>

This really itched me to do a small code review, but I immediately realized that I haven't written code that is suited
for the task at hand, in a long while. For those unfamiliar with the FizzBuzz challenge: it is a simple programming
challenge that is sometimes given at job interviews, so the employing party can get an understanding of the problem
solving skills of the applicant.

In this article, I will show you how FizzBuzz is often implemented and will complement that with an implementation that
solves the domain problem that can be deferred from the same challenge.

## The challenge

The challenge is as follows:

> Write a short program that prints each number from 1 to 100. 
> * For each multiple of 3, print "Fizz" instead of the number. 
> * For each multiple of 5, print "Buzz" instead of the number. 
> * For numbers which are multiples of both 3 and 5, print "FizzBuzz" instead of the number.

The author of the post [solved it](http://sandbox.onlinephpfunctions.com/code/7bf00a6af2ea6761fa6d0e7afde9b473a88ce3d1)
as follows:

```php
<?php

$v1 = 3;
$v2 = 5;

foreach (range(1, 100, 1) as $number) {
	
	if (($number % $v1 == 0) && ($number % $v2 == 0))  {
		echo "FizzBuzz".' ';
		continue;
	}
	elseif ($number % $v1 == 0) {
		echo "Fizz".' ';
		continue;
	}
	elseif ($number % $v2 == 0) {
		echo "Buzz".' ';
		continue;
	}
	else {
		echo $number.' ';
	}
}
```

## The review

The following things can be noted here:

1. Combining `foreach` and `range` takes up memory where it isn't necessary. This is of no concern for the specific case
   requested by the challenge, but could be easily optimized using a `for` loop.
2. Magic numbers are used in variables `$v1` and `$v2`, which again, is no real concern for the challenge, but leaves
   the reader / maintainer of the code with vague expressions.
3. If the code was written slightly differently, the [NPath complexity](https://codellama.io/docs/npath-complexity/)
   could be halved or less, due to a high number of paths created by `if`'s and `else`s. The first `if` is objectively
   superfluous. The last `else` as well.
4. Again, out of scope of the challenge, perhaps, but this solution doesn't really address the domain problem that is
   looking for a solution. The real question of the challenge, in my opinion, is to show each matching word for a
   specific modulo match, or else a number.
   
## Gold plating

Keeping all of the above in mind, the following is my gold plated answer to the FizzBuzz challenge in PHP:

```php
<?php

namespace Acme\FizzBuzz;

use Generator;

/**
 * Create a sequence of numbers and words that match the current offset.
 * 
 * @param array<int,string> $dictionary
 * @param int               $start
 * @param int               $size
 * @param int               $step
 * @param int               $modulo
 * 
 * @yield string
 * @return Generator
 */
function createSequence(
    array $dictionary,
    int $start,
    int $size,
    int $step = 1,
    int $modulo = 0
): Generator {
    for ($index = $start; $index <= $size; $index += $step) {
        $entry = '';
        foreach ($dictionary as $offset => $word) {
            if ($index % $offset === $modulo) {
                $entry .= $word;
            }
        }
        
        yield $entry === '' ? $index : $entry;
    }
}
```

## Meeting acceptance criteria

Now, to achieve the result for the FizzBuzz challenge, the function can be invoked as follows:

```php
<?php
$sequence = \Acme\FizzBuzz\createSequence(
    [
        3 => 'Fizz',
        5 => 'Buzz'
    ],
    1,
    100
);

foreach ($sequence as $entry) {
    echo $entry . PHP_EOL;
}
```

## Measuring results

[The result](https://3v4l.org/D5KfK) is a list ranging from 1 to 100, having *Fizz*, *Buzz* and *FizzBuzz* substitute
the numeric offset where applicable.

Let's validate if the findings for the original solution have been solved:

> Combining `foreach` and `range` takes up memory where it isn't necessary. This is of no concern for the specific case
  requested by the challenge, but could be easily optimized using a `for` loop.

By using a for loop, creating sequences for high ranges is possible. Because a generator is used, the footprint is so low
that the bottleneck of the application would be execution time or output buffering, depending on the environment in which
it runs. 

> Magic numbers are used in variables `$v1` and `$v2`, which again, is no real concern for the challenge, but leaves
  the reader / maintainer of the code with vague expressions.

By defining the offsets in a dictionary, the numbers are no longer magic, but configured.

> If the code was written slightly differently, the NPath complexity could be halved or less, due to a high number of
  paths created by `if`'s and `else`s. The first `if` is objectively superfluous. The last `else` as well.

Although nesting a `foreach` inside the `for` has increased the cyclomatic complexity, it now only has a single `if`
expression used to match all words against the current index.

> Again, out of scope of the challenge, perhaps, but this solution doesn't really address the domain problem that is
  looking for a solution. The real question of the challenge, in my opinion, is to show each matching word for a
  specific modulo match, or else a number.

By making the code agnostic of the expected output of the program, it became testable and maintainable whenever the use
case changes, either slightly or completely. It now solves a domain problem, without being bound to the domain variables.

## Conclusion

I hope you enjoyed this read and picked up a thing or two about problem solving. The reason why this article uses the
term gold plating, is because my solution is obviously overkill to solve the given challenge. However, in my opinion it
better reflects how we solve domain problems in real life, allowing for business rules and variables to change.

Being able to quickly adapt at the needs of the business is a really important part of our work. Let's make job
interviews reflect that, instead of giving applicants some abstract problem to solve.

<script async src="//embed.redditmedia.com/widgets/platform.js" charset="UTF-8"></script>