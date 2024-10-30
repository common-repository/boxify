<?php
/* Boxify Admin Page
 * -----------------
 * Includes CSS & JS to avoid loading extra files.
 * Date : 07/08/2012
 */


define(BOXIFY_DIR, plugin_dir_url(__FILE__));
?>
<div class="boxify-admin">
	<p class="page_title">Boxify | <span>Box Design Helper.</span></p>
	<div class="half left">
		<p class="title">Box Parameters :</p>
		<ul id="styling">
			<li>
				<label for="box_text">Box Text</label>
				<textarea id="box_text" rows="3" cols="20">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</textarea>
			</li>
			<li>
				<label for="text_color">Text Color</label>
				<input id="text_color" name="text_color" value="white" type="text" />
				<span>The color of the text inside the box (Normally control from the Edit Post Area)</span>				
				
			</li>
			<li>
				<label for="box_spacing">Box Spacing</label>
				<input id="box_spacing" name="box_spacing" value="0" type="text" />
				<span>The spacing between the Box and the elements around it. in pixels.</span>				
			</li>
			<li>
				<label for="padding">Padding</label>
				<input id="padding" name="padding" value="5" type="text" />
				<span>The spacing between the Box’s content and its edges. in pixels</span>		
			</li>
			<li>
				<label for="background_color">Background Color</label>
				<input id="background_color" name="background_color" value="black" type="text" />
				<span>The Color of the background of the Box. (hex, colors, rgba)</span>		
			</li>
			<li>
				<label for="background_opacity">Background Opacity</label>
				<input id="background_opacity" name="background_opacity" value="80" type="text" />
				<span>Defines how opaque would be the Box’s background. In precentage (0-100).</span>		
			</li>
			<li>
				<label for="border_width">Border Width</label>
				<input id="border_width" name="border_width" value="2" type="text" />
				<span>The width of the Box’s border. in pixels.</span>		
			</li>
			<li>
				<label for="border_style">Border Style</label>
				<select id="border_style" name="border_style">
					<option value="solid">Solid</option>
					<option value="dashed">Dashed</option>
					<option value="dotted">Dotted</option>
				</select>
			</li>
			<li>
				<label for="border_color">Border Color</label>
				<input id="border_color" name="border_color" value="red" type="text" />
				<span>The Color of the border. (hex, colors, rgba)</span>		
			</li>
			<li>
				<label for="border_radius">Border Radius</label>
				<input id="border_radius" name="border_radius" value="0" type="text" />
				<span>Corner Radius of the border. in pixels.</span>		
			</li>
			<li>
				<label for="height">Height</label>
				<input id="height" name="height" value="100" type="text" />
				<span>Height of box. in pixels.</span>		
			</li>
			<li>
				<label for="width">Width</label>
				<input id="width" name="width" value="200" type="text" />
				<span>The width of box (only for presentation purposes. usually controlled by cols_use/cols ratio)</span>		
			</li>
		</ul>	
	</div>
	<div class="half right">
		<p class="title">Instructions :</p>
		<p class="instructions">
			Play around with the box parameters to your left until you reach the design you want. Then just copy the shortcode that appears in the box in the bottom to the post.
			<br /><br />
			Pay attention that this are not all the parameters that Boxify accepts. Icons and Cross Post Boxes are only controlled from within the edit post.
			<br /><br />
			To learn anything you need to know about about the usage of Boxify and its parameters hop to this <a href="">detailed boxify tutorial</a>.
		</p>
		<p class="title">How it looks :</p>
		<div class="inbox">
			<div class="boxify">
				<div class="boxify-background"></div>
				<div class="boxify-container"></div>
			</div>
		</div>
		<p class="title">Copy&Paste the code in this Box :</p>
		<div class="shortcode"></div>
	</div>
</div>