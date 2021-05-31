<?php
$document = $PAGE["document"];
$data = $document->data;
use Prismic\Dom\RichText;

/* --------------- *
echo "<pre data-smooth>";
print_r($document);
echo "</pre>";
/* --------------- */
?>

<section class="small-hero">
	<img src="https://images.prismic.io/guille/cae2b46c-a9ad-42db-ae42-cb34371626a0_heroimage.jpg?auto=compress,format" alt="personal pic">
	<div class="copy">
		<h1><?php echo $data->hero_header[0]->text ?></h1>
		<h1>Web Developer <span>based in Mexico City.</span></h1>
		<p>I am a junior web developer with a creative perspective</p>
</section>
<section id="experience" class="experience">
	<p>Work Experience</p>
	<h2>Companies i have worked for in the past </h2>
	<div class="jobs">
		<div class="single jobs">
			<h2>01</h2>
			<h4 class="color">Google,</h4><h4>Interaction Designer</h4>
			<p class="description jobs">I currently am the lead designer on the interaction design team for Google Play.</p>
		</div>
		<div class="single jobs">
			<h2>01</h2>
			<h4 class="color">Google,</h4><h4>Interaction Designer</h4>
			<p class="description jobs">I currently am the lead designer on the interaction design team for Google Play.</p>
		</div>
		<div class="single jobs">
			<h2>01</h2>
			<h4 class="color">Google,</h4><h4>Interaction Designer</h4>
			<p class="description jobs">I currently am the lead designer on the interaction design team for Google Play.</p>
		</div>
	</div>
</section>
<section class="values">
	<div>
		<h2>Philosophy & Values</h2>
		<p>I think everyone wants the same thing - relationship with humanity, peace with the metaphysical, and experience with the universe. I try to grasp these things with my values: authenticity, creativity, & hospitality.</p>
		<a href="#"> More About Me</a>
	</div>
	<img src="resources/values.jpg" alt="values pic"/>
</section>
<section class="skillset">
	<div class="copy">
		<h2>Skillset</h2>
		<p>With skills in over 4 different fields of design, I am the perfect person to hire when it comes to a full fledged project. Whatever your needs are, I can pretty much take on any challenge.s</p>
	</div>
	<div class="skills">
		<div class="single skills">
			<img src="resources/skill.png">
			<h4>Product Design</h4>
			<p>Working at Facebook has taught me a lot about how to understand users, solve problems and build great products.</p>
		</div>
		<div class="single skills">
			<img src="resources/skill1.png">
			<h4>Product Design</h4>
			<p>Working at Facebook has taught me a lot about how to understand users, solve problems and build great products.</p>
		</div>
		<div class="single skills">
			<img src="resources/skill2.png">
			<h4>Product Design</h4>
			<p>Working at Facebook has taught me a lot about how to understand users, solve problems and build great products.</p>
		</div>
		<div class="single skills">
			<img src="resources/skill3.png">
			<h4>Product Design</h4>
			<p>Working at Facebook has taught me a lot about how to understand users, solve problems and build great products.</p>
		</div>
	</div>
</section>
<div class="logos">
	<img src="resources/java.png">
	<img src="resources/css-3-logo-png-transparent.png">
	<img src="resources/figma-1-logo-png-transparent.png">
	<img src="resources/phpstorm-logo-svg-vector.svg">
</div>
<section id="projects" class="projects">
	<p>My Projects</p>
	<h2>Work that i've done for the past 8 years</h2>
	<div class="projects grid">
		<div class="single projects">
			<img src="resources/projects.jpg">
			<h3>Restaurant Web Design</h3>
			<p>I worked with the guys at CBRE to redesign their entire website and mobile app fro both Android and iOS. This project lasted for 4 months and was a very challenging one.</p>
		</div>
		<div class="single projects">
			<img src="resources/projects1.jpg">
			<h3>Restaurant Web Design</h3>
			<p>I worked with the guys at CBRE to redesign their entire website and mobile app fro both Android and iOS. This project lasted for 4 months and was a very challenging one.</p>
		</div>
		<div class="single projects">
			<img src="resources/projects2.jpg">
			<h3>Restaurant Web Design</h3>
			<p>I worked with the guys at CBRE to redesign their entire website and mobile app fro both Android and iOS. This project lasted for 4 months and was a very challenging one.</p>
		</div>
		<div class="single projects">
			<img src="resources/projects3.jpg">
			<h3>Restaurant Web Design</h3>
			<p>I worked with the guys at CBRE to redesign their entire website and mobile app fro both Android and iOS. This project lasted for 4 months and was a very challenging one.</p>
		</div>
		<a href="#">View All Projects</a>
	</div>
</section>
<section class="social">
	<div class="copy">
		<h2>Instagram</h2>
		<p>If you area a person who enjoys photography, then I highly recommend that you check out my Instagram. I’m an avid traveller and I capture the best moments that I would love to cherish with the world</p>
		<a href="#">Follow me on IG</a>
	</div>
	<img src="resources/instagram.jpg">
</section>

<section class="dribbble">
	<h2>Dribbble</h2>
	<p>Each dribbble shot is made with love and care. Do check out my work on Dribbble. Likes and comments are appreciated.</p>
	<a href="#">Follow me on Dribbble</a>
	<img src="resources/dribbble.jpg">
</section>
<section class="about">
	<div class="copy">
		<h2>This is what people say about me</h2>
		<p>Here are a few lines from people who I have worked with over the past 8+ years in my design career.</p>
		<a href="#">See all testimonials</a>
	</div>
	<div class="reviews">
		<div class="single reviews">
			<img src="resources/review.jpg">
			<h4>‘’Robin is one of the best designers I have worked with in my entire life. He is a designer who is very capable of taking up complex projects and delivers impeccable design.’’</h4>
			<p class="employer">Josh Kirk</p>
			<p>Churero</p>
		</div>
		<div class="single reviews">
			<img src="resources/review1.jpg">
			<h4>‘’Robin is one of the best designers I have worked with in my entire life. He is a designer who is very capable of taking up complex projects and delivers impeccable design.’’</h4>
			<p class="employer">Josh Kirk</p>
			<p>Churero</p>
		</div>
		<div class="single reviews">
			<img src="resources/review2.jpg">
			<h4>‘’Robin is one of the best designers I have worked with in my entire life. He is a designer who is very capable of taking up complex projects and delivers impeccable design.’’</h4>
			<p class="employer">Josh Kirk</p>
			<p>Churero</p>
		</div>
	</div>
</section>
<section class="hobbies">
	<h2>Hobbies</h2>
	<p>some interests i have besides web developing</p>
	<div class="single hobbies">
		<div class="hobbie">
			<h4>Screenwriting</h4>
			<img src="resources/hobbie.jpeg">
		</div>
		<div class="hobbie">
			<h4>Screenwriting</h4>
			<img src="resources/hobbie1.jpeg">
		</div>
		<div class="hobbie">
			<h4>Screenwriting</h4>
			<img src="resources/hobbie2.jpeg">
		</div>
	</div>
</section>
<section id="contact" class="contact">
	<div class="copy">
		<h2>Contact me</h2>
		<p>Now that you know a lot about me, let me know if you are interested to work with me.</p>
	</div>
	<div class="input-group">
		<div class="input-block">
			<label for="name">Name:</label>
			<input type="text" id="name" name="name" required size="30">
		</div>
		<div class="input-block">
			<label for="email">Email:</label>
			<input type="text" id="email" name="email" required size="30">
		</div>
		<div class="input-block">
			<label for="comments">Comments</label>
			<input type="text" id="comments" name="comments" required size="100">
		</div>
		<button class="favorite styled"
				type="button">
			Let's Get Started
		</button>
	</div>
</section>
