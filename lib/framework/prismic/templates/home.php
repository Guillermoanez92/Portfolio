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
	<img src="<?php echo $data->hero_image->url ?>" alt="personal pic">
	<div class="copy">
		<h1><?php echo $data->hero_header[0]->text ?></h1>
		<p> <?php echo $data->hero_copy[0]->text ?></p>

</section>
<section id="experience" class="experience">
	<p><?php echo $data->work_history_eyebrow[0]->text ?></p>
	<h2><?php echo $data->work_history_header[0]->text ?></h2>
	<div class="jobs">
		<?php foreach ($data->work_history_repeater as $key => $item) { ?>
			<div class="single jobs">
				<h2>0<?php echo $key + 1 ?></h2>
				<h4><?php echo $item->title[0]->text ?></h4>
				<p class="description jobs"><?php echo $item->copy[0]->text ?></p>
			</div>
		<?php } ?>
	</div>
</section>
<section class="values">
	<div>
		<h2><?php echo $data->values_header[0]->text ?></h2>
		<p><?php echo $data->values_copy[0]->text ?></p>
	</div>
	<img src="<?php echo $data->values_image->url ?>" alt="values pic"/>
</section>
<section class="skillset">
	<div class="copy">
		<h2><?php echo $data->skillset_header[0]->text ?></h2>
		<p><?php echo $data->skillset_copy[0]->text ?></p>
	</div>
	<div class="skills">
		<?php foreach ($data->skillset_repeater as $key => $item) { ?>
		<div class="single skills">
			<img src=<?php echo $item->icon->url ?>>
			<h4><?php echo $item->title[0]->text ?></h4>
			<p><?php echo $item->copy[0]->text ?></p>
		</div>
		<?php } ?>
	</div>
</section>
<div class="logos">
	<?php foreach ($data->skillset2_repeater2 as $key => $item) { ?>
	<img src=<?php echo $item->icon->url ?>>
	<?php } ?>
</div>
<section id="projects" class="projects">
	<p><?php echo $data->projects_eyebrow[0]->text ?></p>
	<h2><?php echo $data->projects_header[0]->text ?></h2>
	<div class="projects grid">
		<?php foreach ($data->projects_repeater as $key => $item) { ?>
		<div class="single projects">
			<img src=<?php echo $item->icon->url ?>>
			<h3><?php echo $item->title[0]->text ?></h3>
			<p><?php echo $item->copy[0]->text ?></p>
		</div>
		<?php } ?>
	</div>
</section>
<section class="social">
	<div class="copy">
		<h2><?php echo $data->social_header[0]->text ?></h2>
		<p><?php echo $data->social_copy[0]->text ?></p>
		<a href="https://www.instagram.com/guillermo.anez/"><?php echo $data->social_anchor_tag[0]->text ?></a>
	</div>
	<img src=<?php echo $data->social_image->url ?>
</section>

<section class="dribbble">
	<h2>Dribbble</h2>
	<p>Each dribbble shot is made with love and care. Do check out my work on Dribbble. Likes and comments are appreciated.</p>
	<a href="#">Follow me on Dribbble</a>
	<img src="https://images.prismic.io/guille/3272d086-9d12-431a-90e4-f274a963dd4c_dribbble.jpg?auto=compress,format">
</section>
<section class="about">
	<div class="copy">
		<h2>This is what people say about me</h2>
		<p>Here are a few lines from people who I have worked with over the past 8+ years in my design career.</p>
		<a href="#">See all testimonials</a>
	</div>
	<div class="reviews">
		<div class="single reviews">
			<img src="https://images.prismic.io/guille/e8983454-4846-42d7-81dd-2a4fcec9c446_review.jpg?auto=compress,format">
			<h4>‘’Robin is one of the best designers I have worked with in my entire life. He is a designer who is very capable of taking up complex projects and delivers impeccable design.’’</h4>
			<p class="employer">Josh Kirk</p>
			<p>Churero</p>
		</div>
		<div class="single reviews">
			<img src="https://images.prismic.io/guille/e78091a7-88d5-442c-9b88-d14f54505edf_review1.jpg?auto=compress,format">
			<h4>‘’Robin is one of the best designers I have worked with in my entire life. He is a designer who is very capable of taking up complex projects and delivers impeccable design.’’</h4>
			<p class="employer">Josh Kirk</p>
			<p>Churero</p>
		</div>
		<div class="single reviews">
			<img src="https://images.prismic.io/guille/cdc66af6-e308-44b3-a426-6124e76af3c0_review2.jpg?auto=compress,format">
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
			<img src="https://images.prismic.io/guille/6e2b2f23-d7eb-4069-8362-9fee815c5101_hobbie.jpeg?auto=compress,format">
		</div>
		<div class="hobbie">
			<h4>Screenwriting</h4>
			<img src="https://images.prismic.io/guille/92b18e5e-e8b4-4e89-a5ae-1b7ca6e11978_hobbie1.jpeg?auto=compress,format">
		</div>
		<div class="hobbie">
			<h4>Screenwriting</h4>
			<img src="https://images.prismic.io/guille/a5b3374d-69a8-45ee-bc16-9d402d4ba6a8_hobbie2.jpeg?auto=compress,format">
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
