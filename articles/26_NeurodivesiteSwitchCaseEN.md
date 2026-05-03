# Mrs. OutKase is desperately looking for her box

*(spoiler: she eventually finds it)*

*By Katy Ho — Hors Kadre | May 2026*

---

*This text is not for the gifted. Not for those with ADHD.*
*It's for you — if you've ever felt in the wrong box.*
*Or in none at all.*
*Or in too many at once.*
*That is to say: almost everyone.*

---

## 0. The Program

*For non-developers: a switch/case is like a nightclub bouncer with a list. If your name is on it — you're in. If not — you stay outside. Even if you booked.*

*For developers: you already see the problem.*

---

**🖼️ IMAGE — SIMPLE VERSION HERE**

```java
// Neurodiversity detection system v1.0
// Tested on: boys, agitated children
// Last update: never

switch (who_you_are) {
  case AGITATED_BOY:   prescribe_ritalin();  break;
  case BRILLIANT_BOY:  skip_a_grade();       break;
  default:             figure_it_out();      break;
}
```

---

This is what the medical system does when you arrive with an atypical brain.

If you're an agitated boy — you're in. Ritalin and a seat at the back of the class.

If you're a brilliant boy — you're in too. Skip a grade. Well done.

And if you're... something else?

`default: figure it out.`

Thirty years this code has been running in production. Nobody shipped the update.

---

**🖼️ IMAGE — DETAILED VERSION HERE**

```java
// Neurodiversity detection system v1.0
// Tested on: boys, agitated children
// Last update: never

try {
  if (patient == BOY) {
    switch (profile) {
      case GIFTED: skip_grades();        break;
      case ADHD:   prescribe_ritalin();  break;
      default:     figure_it_out();      break;
    }
  }

} catch (GiftedADHDWoman e) {

  switch (who_you_really_are) {
    case WOMAN:   // to be processed
    case GIRL:    // to be processed
    case GIFTED:  // to be processed
    case ADHD_F:  // to be processed
    default:
      // TODO: planned for 2099.
      // In the meantime: have you tried yoga?
  }
}
```

---

And look at the `catch`. Even when the system "catches" your case — it opens a new switch. And all the cases are empty.

`// TODO: planned for 2099.`

`// In the meantime: have you tried yoga?`

I'm not joking. Well, yes I am. But still.

**Or maybe it's you who's the problem?** 😄

---

## 1. Dr. ClosedCase and the Caring Email

A specialist psychiatrist. Author of reference books on ADHD. Recommended by her doctors.

Mrs. OutKase sends her full file. Her assessments. Her history. Her lived experience.

He replies by email.

No appointment. No interview. An email.

---

> *"Many of the symptoms currently listed in the 2023 assessment are not specific to ADHD — they can be found in other conditions common in adults."*

Translation: your symptoms are ordinary. Everyone is tired, honey.

> *"DSM-5 diagnostic criteria require that symptoms be present in a significant way **before the age of 12**."*

Before 12.

You know what was happening before she was 12? She was a quiet little girl. Good student. Discreet. She compensated. She adapted. She smiled.

Exactly what little girls are supposed to do.

Exactly what the manual doesn't know how to read.

Because the manual was written for boys who **don't do that**.

Dr. ClosedCase opened his switch. Looked for her case. Didn't find it. Closed the file. By email.

`default: no ADHD detected. Have a nice day.`

What he didn't say — what the DSM-5 quietly whispers in its footnotes — is that the "before 12" criterion was built on hyperactive, noisy boys. Not on girls who learned very early that being quiet is survival.

Her case didn't exist in his system.

So she didn't exist.

---

*Mrs. OutKase read that email once. Didn't understand.*
*Read it again. Same.*
*Five times. Ten times. Twenty times.*
*Then she understood.*
*And she cried.*

---

## 2. Mrs. CopyPaste — the Teacher with One Answer

There comes the moment when she asks about her daughter.

She's bored. She doesn't shine. She's quiet. Good student. Not disruptive.

Mrs. OutKase speaks to her teacher. Mrs. CopyPaste.

*"She scored 145 on the WISC."*

> *"Do you know how many parents come to me claiming their child is gifted? An IQ test means nothing. And you shouldn't push your children."*

*"She's in first grade."*

> *"Do you know how many parents... shouldn't push their children."*

*"She codes in Scratch. By herself. For fun."*

> *"Do you know how many parents... shouldn't push their children."*

```java
// Mrs. CopyPaste v1.0
String response = "Do you know how many parents..." +
                  "An IQ test means nothing." +
                  "Don't push your children.";

while (parent_speaks) {
  display(response); // always the same
}

// Developer note:
// No update planned.
// Running since 1987.
```

---

> 💡 *Further reading — A meta-analysis of 130 studies (ScienceDirect, 2013) shows that boys are 1.19 times more likely to be identified as gifted. The gap is particularly marked in pre-adolescents — and when the identification criterion is visible classroom behaviour.*

---

*Mrs. OutKase heard those words once. Didn't understand.*
*Heard them again. Same.*
*Five times. Ten times. Twenty times.*
*Then she understood.*
*And she cried.*

---

## 3. Mrs. AuthenticOrNothing and the Deadly Compliment

There are Facebook groups reserved for **tested** gifted people only.

Not sensitives. Not zebras. The **tested** ones. WISC, WAIS, verified IQ, official stamp. One more switch/case. Just with a velvet rope.

Mrs. OutKase posts an article. Sourced. Lived. Written with a brain running at 4,000 rpm.

Someone comments:

> *"I enjoyed your article. The rhythm, the flow. I read it to the end. But it's a shame your text was optimized by AI."*

Being gifted in her box means what, exactly? Calculating without a calculator? Writing without tools? Suffering without help?

Mrs. OutKase has ADHD. AI is her cognitive prosthetic. Like glasses for the short-sighted. Nobody tells a short-sighted person *"shame your eyes were optimized by lenses."*

`// Using your tools = cheating`
`// Suffering in silence = authentic`
`// This logic has a bug. Find it.`

---

*Mrs. OutKase read that comment once. Didn't understand.*
*Read it again. Same.*
*Five times. Ten times. Twenty times.*
*Then she understood.*
*And she cried.*

---

## 4. "Women with high IQ are often autistic" — the ad that lies twice

Mrs. OutKase scrolls Facebook.

Between her neighbour's post about her cat and a quiche recipe — an ad.

**🖼️ FACEBOOK AD SCREENSHOT HERE**

> **"Women with high IQ are often autistic."**
> *"If you can answer these 15 complex intellectual questions, your IQ is above 130. Take the test now."*

**Lie #1:** 15 Facebook questions = IQ above 130.

No.

An IQ is measured with a WAIS or WISC. Administered by a psychologist. Over several hours. With subtests, indices, qualitative analysis. Not with a form between the quiche recipe and the neighbour's cat.

**Lie #2:** gifted woman = autistic.

No.

There are gifted autistic women. There are autistic women without giftedness. There are gifted women without autism.

Mrs. OutKase is gifted. Mrs. OutKase has ADHD. Mrs. OutKase is not autistic.

Her husband is Asperger. Her son is Asperger. She knows autism from the inside — not as a label, as a daily lived and loved reality.

It's not the same box.

And lumping these boxes together because *"women are discreet"* — that's still switch/case. More subtle. More seemingly kind. Same bug.

The medical system puts women in `default`.
Facebook algorithms put them all in the same box.
Both miss the target.

**The difference?**

The medical system, at least, doesn't charge you the premium subscription.

*I say that. I say nothing.* 😄

---

> 💡 *Further reading — The "camouflage" phenomenon in atypical women is scientifically documented. Lai et al. (2017, PMC) show that women mask their difficulties more — which delays diagnosis by an average of 4 to 9 years compared to men. Resemblance of profiles does not mean identity of profiles.*

---

*Mrs. OutKase read that ad once. Didn't understand.*
*Read it again. Same.*
*Five times. Ten times. Twenty times.*
*Then she understood.*
*This time — she didn't cry. She laughed.*
*Then she wrote this article.* 😄

---

## 5. The real problem with boxes

Mrs. OutKase is a different and unique woman.

Like every woman on earth.

Like every human on earth, actually.

And she doesn't need a box.

Except.

To get learning support — you need a diagnosis.
To get disability recognition — you need an official label.
To be taken seriously — you need a stamp, a code, a checked box.

The problem with boxes — it's not that they exist.

It's that they've become the **only currency** to access what you need.

No box? No rights.
Wrong box? Wrong rights.
Too many boxes? System crash.

`// People without a box:`
`// the silent majority`
`// compensating alone`
`// since forever`

It's unfair for those who have no box.

It's unfair for those who are "lucky" enough to find one — and had to fight for years to get there.

It's unfair for everyone.

Except the system.

The system sleeps just fine.

---

## 6. To you who don't fit any box

This article is for you.

Not only if you have ADHD. Not only if you're gifted. Not only if you have a stamp, a file, a checked box.

For you too — you who function "normally" by the system's standards. You who have never had a diagnosis. You who have just sometimes felt slightly off. Not quite in the right place. Not quite seen for who you really are.

Because boxes — they crush everyone.

They tell the brilliant boy he must skip grades.
They tell the quiet girl she's fine.
They tell the worried parent they push too hard.
They tell the exhausted adult they're just burned out.

And to everyone else — those who fit no box, those who fit the wrong one, those who fit too many — they say the same thing:

`default: figure it out.`

You don't need to skip grades to be intelligent.
You don't need a diagnosis to have value.
You don't need to be struggling to deserve attention.
You don't need a box to exist.

The system needs boxes to function.

**You don't.**

`// You`
`// Status: UnknownException`
`// Translation: unexplored`
`// Potential: unmeasured`
`// Value: not null`

Mrs. OutKase sees you.

---

## The ending

With all the misunderstandings. With all the tears. With all the emails read twenty times. With all the *"figure it out"* and the *"have you tried yoga"*.

Mrs. OutKase read. She understood. And she stopped crying.

She found her box. The world.

---

This Mrs. OutKase — was me.

---

Rejected at my first job interview — IQ test.
Rejected at engineering school — IQ test.
Admitted at technical college — practical exam. Electronics. Applied math. Real problem. Real solution.

Apprentice. Then engineer. Then expert.

Today I run the control system of one of the most powerful MRI machines in the world. I'm preparing an AI certification. I'm looking for a PhD supervisor.

My WAIS: 130. My working memory: meh. I compensate differently.

My ADHD: diagnosed at 46. Nine years after my giftedness. Detected thanks to my children — not thanks to the system.

The night before my WAIS, I kept thinking: *"Who do I think I am. I'll score 2. I'm useless."*

My 6-year-old daughter said it was fun.

145.

Same family. Same gene. Two generations.

She won't have to wait until she's 37 to understand herself.

That's why I write.

---

*This article about boxes — it was read to the end.*
*By someone with ADHD who didn't exist in the system.*
*Proof that it's possible.*
*Without jargon. Without boxes. Without yoga.*

---

*If you read this far.*

*And you recognized yourself in Dr. ClosedCase.*
*Or in Mrs. CopyPaste.*
*Or in Mrs. AuthenticOrNothing.*

*And you were convinced that the box system was the only way.*

*And now you have a doubt.*

*Then.*

*You read to the end.*
*An article without boxes.*
*Written by someone who didn't exist in your system.*

*Bug confirmed.*

*I say that. I say nothing.* 😄

---

`// catch (UnknownPatientException e)`
`// "This profile does not exist."`
`// Spoiler: it does.`

**E=HK² 💥**

---

## Sources

- DSM-5 (2013 revision) — ADHD diagnostic criteria and gender bias — APA
- HAS (2024) — Adult ADHD recommendations — has-sante.fr
- Lai et al. (2017) — *Quantifying and exploring camouflaging in men and women with autism* — PMC
- ScienceDirect (2013) — *Gender differences in identification of gifted youth* — meta-analysis 130 studies
- Doris Perrodin-Carlen — *Et si elle était surdouée ?* (2015) — French reference on gifted women
- WAIS-IV / WISC-V — Wechsler Intelligence Scales — clinical documentation
- Inserm (2025) — Adult ADHD report
- Personal experience — 46 years of medical running gag, a lot of coffee, a daughter who thought it was fun ✅

---

*Medium title:* `Mrs. OutKase is desperately looking for her box`
*(46 characters ✅)*

*Subtitle:* `The medical system runs a switch/case. Last update: never. This is the story of everyone who fell into default.`

*5 Keywords:* `Neurodiversity` · `ADHD Women` · `Gifted Adults` · `Late Diagnosis` · `Women In Tech`

*Article — Hors Kadre — Katy Ho — May 2026*
