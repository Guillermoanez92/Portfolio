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

<section class="hero-section">
	<img src="<?php echo $data->hero_image->url ?>" alt="personal pic">
	<div class="copy">
		<?php echo RichText::asHtml($data->hero_header); ?>
		<p> <?php echo $data->hero_copy[0]->text ?></p>
	</div>
</section>
<section id="work_history" class="work_history">
	<p class="eyebrow"><?php echo $data->work_history_eyebrow[0]->text ?></p>
	<h2><?php echo $data->work_history_header[0]->text ?></h2>
	<div class="companies">
		<?php foreach ($data->work_history_repeater as $key => $item) { ?>
			<div class="company">
				<p class="eyebrow">0<?php echo $key + 1 ?></p>
				<?php echo RichText::asHtml($item->title); ?>
				<p class="description"><?php echo $item->copy[0]->text ?></p>
			</div>
		<?php } ?>
	</div>
</section>
<section class="values">
	<div class="copy">
		<h2><?php echo $data->values_header[0]->text ?></h2>
		<p><?php echo $data->values_copy[0]->text ?></p>
	</div>
	<img src="<?php echo $data->values_image->url ?>" alt="values pic"/>
</section>
<section class="skillset">
	<div class="left">
		<h2><?php echo $data->skillset_header[0]->text ?></h2>
		<p><?php echo $data->skillset_copy[0]->text ?></p>
	</div>
	<div class="right">
		<?php foreach ($data->skillset_repeater as $key => $item) { ?>
			<div class="skill">
				<img src=<?php echo $item->icon->url ?>>
				<h4><?php echo $item->title[0]->text ?></h4>
				<p><?php echo $item->copy[0]->text ?></p>
			</div>
		<?php } ?>
	</div>
</section>
<section class="logos">
	<div class="track">
		<div class="inner">
			<?php foreach ($data->skillset2_repeater2 as $key => $item) { ?>
				<div class="block">
					<img src=<?php echo $item->icon->url ?>>
				</div>
			<?php } ?>
		</div>
	</div>
</section>
<section id="projects" class="projects">
	<div class="heading">
		<p><?php echo $data->projects_eyebrow[0]->text ?></p>
		<h2><?php echo $data->projects_header[0]->text ?></h2>
	</div>
	<div class="grid">
		<?php foreach ($data->projects_repeater as $key => $item) { ?>
			<div class="block">
				<img src=<?php echo $item->icon->url ?>>
				<div class="copy">
					<h3><?php echo $item->title[0]->text ?></h3>
					<p><?php echo $item->copy[0]->text ?></p>
				</div>
			</div>
		<?php } ?>
	</div>
</section>
<section class="social-module">
	<div class="left">
		<h2><?php echo $data->social_header[0]->text ?></h2>
		<p><?php echo $data->social_copy[0]->text ?></p>
		<a href="https://www.instagram.com/guillermo.anez/"><?php echo $data->social_anchor_tag[0]->text ?></a>
	</div>
	<div class="right">
		<img src=<?php echo $data->social_image->url ?>>
	</div>
</section>


<section class="dribbble">
	<div class="copy">
		<h2><?php echo $data->dribbble_header[0]->text ?></h2>
		<p><?php echo $data->dribbble_copy[0]->text ?></p>
		<a href="https://dribbble.com/guillermoanez92"><?php echo $data->dribbble_anchor_tag[0]->text ?></a>
	</div>
	<img src=<?php echo $data->dribbble_image->url?>>
</section>

<section class="about">
	<div class="left">
		<h2><?php echo $data->reviews_header[0]->text ?></h2>
		<p><?php echo $data->reviews_copy[0]->text ?></p>
	</div>
	<div class="right">
		<?php foreach ($data->reviews_repeater as $key => $item) { ?>
			<div class="review">
				<img src=<?php echo $item->icon->url ?>>
				<div class="copy">
				<h4><?php echo $item->copy[0]->text ?></h4>
				<p class="employer"><?php echo $item->eyebrow1[0]->text ?></p>
				<p><?php echo $item->eyebrow_2[0]->text ?></p>
				</div>
			</div>
		<?php } ?>
	</div>
</section>
<section class="hobbies">
	<h2><?php echo $data->hobbies_header[0]->text ?></h2>
	<p><?php echo $data->hobbies_copy[0]->text ?></p>

	<div class="tab-wrapper">
		<?php foreach ($data->body as $key => $slice) {
			if ($slice->slice_type === "hobby") { ?>
				<button><?php echo $slice->primary->hobby_title[0]->text ?></button>
			<?php } ?>
		<?php } ?>
	</div>

	<div class="all-hobby-images">
		<?php foreach ($data->body as $key => $slice) {
			if ($slice->slice_type === "hobby") { ?>
				<div class="hobby-images<?php if ($key === 0) { echo " active"; }?>">
					<?php foreach ($slice->items as $idx => $hobby) { ?>
						<img src=<?php echo $hobby->images->url ?>>
					<?php } ?>
				</div>
			<?php } ?>
		<?php } ?>
	</div>
</section>
<section id="contact" class="contact">
	<div class="left">
		<h2><?php echo $data->contact_header[0]->text ?></h2>
		<p><?php echo $data->contact_copy[0]->text ?></p>
	</div>
	<div class="right" class="input-group">
		<div class="input-block">
			<label>Name</label>
			<input class="input validate" type="name"  name="customer[name]"  />
		</div>
		<div class="input-block">
			<label>Email</label>
			<input class="input validate" type="email" name="customer[email]" />
		</div>
		<div class="input-block">
			<label>Message</label>
			<input class="input validate" type="text" name="customer[comments]" />
		</div>
		<button type="submit" class="button submit"><a href="#">Let's Get Started</a></button>
</section>
