# The Cat in the Transformer

*Or why the red screens don't always tell you where the real fault is.*

*By Katy Saintin — Hors Kadre*

---

A cat electrocuted itself in a transformer.

That's the real cause of the outage.

The one we spent hours trying to find, at 4am, at the SOLEIL synchrotron — a particle accelerator near Paris. Every SCADA screen had turned red. Alarms cascading. Racks not responding. The system collapsing all at once, for no apparent reason, in the middle of the night.

And since that night, every time I sit in a school board meeting and a parent says *"honestly, the timetable is a mess — it can't be that hard to fix"* — I think of that cat.

---

## 1. 4am — the screens are red

The on-call phone rings.

I'm a SCADA engineer. I build supervision interfaces — the HMI layer. The part of the control system that operators actually see. What they look at when everything is running smoothly.

And when it isn't.

I walk into the control room.

It isn't.

Christmas tree. Every screen blinking red. Alarms dropping one after another. The system apparently falling apart all at once, for no reason, at 4am.

I'm a SCADA engineer with 13 years of industrial support behind me. I've rebooted live systems. I've debugged architectures nobody understood anymore. I have ADHD — which means at 4am on caffeine, I'm in my natural state: hyperfocused, methodical, absolutely convinced I'm going to find it.

Software bug? Checked.
Network failure? Checked.
Human error? Checked.
Power issue? Checked.

Hours pass. A lot of coffee. The kind of night where you start doubting everything — except yourself, because that's just how I'm wired.

And then the real cause comes in.

A cat had electrocuted itself in a transformer.

---

Dead silence.

Me. SCADA engineer. 13 years of experience. Fully caffeinated. Hyperfocused for hours.

Beaten by a cat.

The photo still exists. So does the video — seven seconds. My manager, relieved, announcing:

*"The machine is coming back up."*

And us, in the control room, laughing.

At 4am.

Because that's support work. You debug for hours. You bring everything you have. And sometimes, the cause is a cat who had no idea what it was doing in a transformer.

*(Honestly. Neither did we.)*

*Rest in peace.*

Our through-line. Literally and figuratively.

---

## 2. And ever since, I keep thinking about that cat

Years later.

I'm a volunteer parent representative at a French high school. Seven years. Non-profit. NVC-trained mediator. The person who sends questions 48 hours before every meeting.

Me — the one who rebooted a synchrotron at 4am because of a cat — I can handle any school board meeting.

*Spoiler: no.*

Because parents see: impossible timetables, cancelled classes, incompatible subject choices, overcrowded classrooms, exhausted teachers, university application chaos, grades that make no sense.

So they reach out. To the teachers. To the administration. To the parent reps — us.

The emails always sound a bit the same:

*"Hi, why does my son finish at 6pm on Tuesdays? Can we change that?"*

Or:

*"My daughter has two free periods in the middle of Thursday. This is ridiculous."*

And honestly? I used to think the same things.

*"What kind of organisation is this."*
*"They're useless."*
*"It can't be that hard to just..."*

The visible front absorbs the visible pressure.

Exactly like in IT support.

And at every tense meeting, I think of that cat.

---

## 3. The day I discovered a school funding allocation

I'm a SCADA engineer. Complex systems. Constraints. Dependencies. Error propagation.

I was going to understand a school funding spreadsheet in five minutes flat.

*(You see where this is going.)*

First school board meeting. The headteacher pulls up the document.

In France, schools receive what's called a DGH — a *Dotation Globale Horaire*, or Global Hourly Allocation. Think of it as the annual teaching-hours budget a school gets from the government. With that — and only that — they have to make the entire school year work.

The equivalent exists everywhere: in the UK it's the National Funding Formula allocation. In the US, it's the district budget per school. Different names, same constraint: a fixed envelope, and everything has to fit inside it.

The headteacher opens the spreadsheet.

Rows. Columns. Sub-groups. Half-groups. Weighted hours. Regulatory minimums. Subject combinations. Options. Languages. Teacher contracts. Budget margins.

Everyone around the table nods.

Me — the person who asks questions at 4am about electrocuted cats, who interrupts every two minutes to understand things, who has roughly the conformity bias of an oyster — I nodded.

*(If you've read my article on the Asch effect, you'll know this is historically significant.)*

I barely said a word that meeting.

Pure survival instinct.

Because the headteacher had a habit of affectionately teasing me about my "psychopath Excel spreadsheets." And for once in my life, I didn't dare open my mouth.

*"Any questions?"*

Internally: yes. Eighty-seven, approximately.

Externally: polite smile. Slow nod.

Dead silence inside my head.

Me. SCADA engineer. The one who debugs industrial systems in real time. Sitting there like a sixth-grader who forgot to do their homework.

*I strongly suspected a second cat had died somewhere.*

---

## 4. What's actually inside that spreadsheet

*(Speaking as someone who was completely lost. And still a little bit, let's be honest.)*

The DGH is the school's annual teaching-hours allocation — distributed by the regional education authority.

With that envelope — and only that — a school has to cover: every class, every subject, every option, every language, every half-group, every room constraint, every regulatory requirement, every planned absence, every ongoing reform, and timetables that have to hold together without anyone having class at midnight.

In the school I know: 1,309 hours to distribute. 31 classes. 1,069 students. 8 subject specialisms — when the national average is 6 or 7. And every possible subject combination accepted, unlike other schools that cap the combinations to keep the timetable manageable.

Pedagogical generosity. Paid for in explosive complexity.

📎 *[SCREENSHOT — French school funding allocation (DGH), anonymised. A real document from a real school. You don't need to speak French. Just look at the columns, the rows, the colour-coded cells. Take your time.]*

Result: some language classes are scheduled at 2.25 hours per week.

2.25 hours.

The first time I saw that, I assumed it was a typo. Or that a teacher was being sliced into ninety-second portions and distributed across several time slots.

*(Reality: one extra hour every four weeks. Because the hours don't divide evenly. Not evenly. Literally.)*

So I did what I always do when I don't understand something: I made a spreadsheet.

With a statistician friend — PhD-level researcher, the kind of person who runs linear regressions to relax — we decided we were going to find the solution. Optimise. Simplify. Solve what the administration had apparently failed to figure out.

We figured twenty minutes.

Three hours later.

Twenty-six different subject combination patterns. For seven Grade 11 classes. With room constraints. Half-groups. Options. Modern languages. Bilingual sections. Teacher contract hours.

American educators call this the Master Schedule. Same beast, different name. Scheduling software runs 20 million calculations per minute to solve it. Our headteacher does it in a spreadsheet.

We looked at each other.

*"This is actually really hard."*

*"Yeah."*

*"Like, really hard."*

*"Yeah."*

Long silence.

*"So what do we do?"*

*"...I have no idea."*

Profound humbling moment.

Me, who had thought it *just needed a bit of organising*. Me, who had silently judged the timetables as "absurd." Me and my PhD friend — two well-wired, well-equipped, genuinely motivated brains — and we had found nothing.

That day, I understood something: some organisations that look absurd from the outside are sometimes just human systems holding together despite everything. And the people keeping them standing deserve better than our impatience.

The headteacher, at the next board meeting, with her smile:

*"Did you look at the subject combinations?"*

*"Yes."*

*"And?"*

*"...It's really hard."*

*"Welcome."*

---

📎 *[SCREENSHOT — French subject combination table, anonymised. Our spreadsheet. Three hours of work. One PhD + one engineering degree. Result: "This is really hard."]*

---

And then there's row 26.

Look at the table. Right at the bottom.

One student. Alone. The only person in the entire grade with that particular combination.

In the US, you know this student. The one who signed up for AP Biology, AP Music Theory, Mandarin Level 4, Jazz Band, and Robotics Club — all in the same semester. Every one of those is a singleton course. One section. One time slot. And they all conflict.

His mother contacted me to say her son had no classmates in any of his subjects. That his schedule made no sense. That he finished at 6pm some evenings. That the school was clearly disorganised.

I showed her the table.

Row 26.

The lone "1" at the end.

She understood.

*(I'm just saying.)*

---

I don't lecture people about timetables anymore.

I tell them about the cat.

*The cat. Always there.*

---

## 5. Teachers — the Level 1 support of the education system

This is the most counter-intuitive thing I've learned in seven years as a parent rep.

Teachers are often the Level 1 support of the whole system.

Parents see the teachers. So they contact the teachers. Logical.

But behind what parents see, the causes can be governmental, budgetary, regulatory — or simply kafkaesque.

During COVID, protocols changed every week. Sometimes every three days. Teachers found out about the new rules at the same time as parents — sometimes after. One metre of distance around every student. In a class of 35 students. In a room of 35 square metres.

I'll let you do the maths.

The teachers didn't decide that. They managed with it. They absorbed the parents' questions, the students' anxiety, the absurdity of the system — while trying to maintain continuity with rules that changed before they'd finished implementing the previous ones.

I spent a night debugging a synchrotron because of a cat. I know what it's like to absorb pressure that has nothing to do with you.

The visible front absorbs the visible pressure.

Even when the fault comes from somewhere else entirely.

Even when the problem is a cat in a transformer.

*Our cat. Always on duty.*

---

## 6. Always the cat

I build complex web applications in a day. I develop supervision tools for particle accelerators. I work on systems where a millisecond error can stop everything.

And the subject combinations of a French high school — with my PhD friend, three hours of spreadsheets, and all our good intentions — we couldn't figure out how to simplify them.

Not because we're not capable.

Because it's genuinely hard.

So the next time someone says *"honestly, how hard can it be to fix the timetable"* — I don't show them the spreadsheet.

I tell them about the cat.

In complex systems — industrial or educational — the visible front often absorbs invisible problems.

The red screens don't always come from the people standing in front of the screens.

Sometimes the fault comes from much further away. From a government decision. From underfunded reform. From a budget that doesn't divide evenly. From twenty-six subject combinations that can't be untangled.

From a cat in a transformer.

**And in both cases: it's not the fault of the people at the front.**

Everyone has their area of expertise.

Even — especially — when you're pretty well wired.

---

*Rest in peace.*

*Our through-line. Literally and figuratively.*

*E=HK² 💥*

---

## Sources & transparency

- School funding allocation 2026 — internal document, anonymised
- Subject combination analysis, Year 12, 2024-2025 — UNAAPE parent representative association
- Back-to-school meeting notes, 2024
- Personal experience — 13 years of IT support at SOLEIL synchrotron, 7 years as volunteer parent rep, a lot of coffee ✅

---

*Tags: SCADA, complex systems, education, school timetabling, support, teachers, parent representative, school funding, France, neurodiversity, systems thinking*
