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
	</div>
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
<div class="lgos">
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
	<img src=<?php echo $data->social_image->url ?>>
</section>

<section class="dribbble">
	<h2><?php echo $data->dribbble_header[0]->text ?></h2>
	<p><?php echo $data->dribbble_copy[0]->text ?></p>
	<a href="https://dribbble.com/guillermoanez92"><?php echo $data->dribbble_anchor_tag[0]->text ?></a>
	<img src=<?php echo $data->dribbble_image->url?>>
</section>
<section class="about">
	<div class="copy">
		<h2><?php echo $data->reviews_header[0]->text ?></h2>
		<p><?php echo $data->reviews_copy[0]->text ?></p>
	</div>
	<div class="reviews">
		<?php foreach ($data->reviews_repeater as $key => $item) { ?>
		<div class="single reviews">
			<img src=<?php echo $item->icon->url ?>
			 <h4><?php echo $item->copy[0]->text ?></h4>
			<p class="employer"><?php echo $item->eyebrow1[0]->text ?></p>
			<p><?php echo $item->eyebrow_2[0]->text ?></p>
		</div>
		<?php } ?>
	</div>
</section>
<section class="hobbies">
	<h2><?php echo $data->hobbies_header[0]->text ?></h2>
	<p><?php echo $data->hobbies_copy[0]->text ?></p>
	<div class="single hobbies">
		<?php foreach ($data->hobbies_repeater as $key => $item) { ?>
		<div class="hobbie">
			<h4><?php echo $item->title[0]->text ?></h4>
			<img src=<?php echo $item->icon->url ?>>
		</div>
		<?php } ?>
	</div>
</section>
<section id="contact" class="contact">
	<div class="copy">
		<h2><?php echo $data->contact_header[0]->text ?></h2>
		<p><?php echo $data->contact_copy[0]->text ?></p>
	</div>
	<div class="input-group">
		<div class="input-block">
			<label>Name</label>
			<input class="input validate" type="name"  name="customer[name]"  />
		</div>
		<div class="input-block">
			<label>E-mail</label>
			<input class="input validate" type="email" name="customer[email]" />
		</div>
		<div class="input-block">
			<label>Comments</label>
			<input class="input validate" type="text" name="customer[comments]" />
		</div>
		<button type="submit" class="button submit">Let's Get Started</button>
</section>
