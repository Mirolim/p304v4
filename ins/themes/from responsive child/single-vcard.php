<?php
/*
Template Name Posts: vCard
@author       Mirolim FGL
*/
?>
<?php get_header('vcard'); ?>
 <div id="vcard">
	<div id="vcard-profile" class="grid fit">
    	<div id="vcard-profile-left" class="grid col-540">
        	<div class="info-block">
            <center>
          <img src="<?php the_field('your_photo');?>" id="vcard-photo" align="left" style="padding: 0px 10px 0pt 43px;"/>
          <h1><span id="vcard-name"><?php the_field('name');?></span></h1>
          <h6><?php the_field('profession');?></h6>
          <p><?php the_field('about_me');?></p>
          </center>
          	</div>
    	</div>
        <div id="vcard-profile-right" class="grid col-380 fit">
        	<ul class="profile-info">
            	<li><label>Name</label><span><?php the_field('name');?></span></li>
                <li><label>Date of birth</label><span><?php the_field('date_of_birth');?></span></li>
                <li><label>Address</label><span> <?php the_field('address');?></span></li>
                <li><label>Email</label><span><?php the_field('email');?></span></li>
                <li><label>Phone</label><span><?php the_field('phone');?></span></li>
                <li><label>Website</label><span><?php the_field('website');?></span></li>
                </ul>
  		</div> 
	</div>
      	  <div id="vcard-buttons" class="grid col-940 fit">
          <center>
          	<ul class="tabs">
	  			<li><a href="#resume" id="resume-btn" class="vcard-btn" >Resume</a></li>
        		<li><a href="#portfolio" id="portfolio-btn" class="vcard-btn" >Portfolio</a></li>
        		<li><a href="#contact" id="contact-btn" class="vcard-btn" >Contact</a></li>
        </ul>
       </center>
  	  </div>   
	<div id="vcard-resume" class="vcard-section">
    	<div id="vcard-resume-employment">
        	<div class="timeline-section">
                  <h3 class="main-heading"><span>Employment</span></h3>
                  <ul class="timeline">
	            	<li>
                    	<div class="timelineUnit">
                    		<h5><?php the_field('emp1');?>
                            	<span class="timelineDate">
									<?php the_field('emp1_year');?>
                                </span>
                            </h5>
                            <p><?php the_field('emp1_about');?></p>
            			</div>
                   </li>
                   <li>
                    	<div class="timelineUnit">
                    		<h5><?php the_field('emp2');?>
                            	<span class="timelineDate">
									<?php the_field('emp2_year');?>
                                </span>
                            </h5>
                            <p><?php the_field('emp2_about');?></p>
            			</div>
                   </li>
                   <li>
                    	<div class="timelineUnit">
                    		<h5><?php the_field('emp3');?>
                            	<span class="timelineDate">
									<?php the_field('emp3_year');?>
                                </span>
                            </h5>
                            <p><?php the_field('emp3_about');?></p>
            			</div>
                   </li>
	            </ul>
                <div class="clear"></div>
                  <h3 class="main-heading"><span>Education</span></h3>
                  <ul class="timeline">
	            	<li>
                    	<div class="timelineUnit">
                    		<h5><?php the_field('edu1');?>
                            	<span class="timelineDate">
									<?php the_field('edu1_year');?>
                                </span>
                            </h5>
                            <p><?php the_field('edu1_about');?></p>
            			</div>
                   </li>
                   <li>
                    	<div class="timelineUnit">
                    		<h5><?php the_field('edu2');?>
                            	<span class="timelineDate">
									<?php the_field('edu2_year');?>
                                </span>
                            </h5>
                            <p><?php the_field('edu2_about');?></p>
            			</div>
                   </li>
	            </ul>
                <div class="clear"></div>
          </div>      
        </div>
        <div id="vcard-resume-media-skills" class="skills-section">
        	<h3 class="main-heading"><span>Graphics and media skills</span></h3>
            <ul class="skills">
            	<li>
                	<h5><?php the_field('media1_name');?></h5>
                    <span class="rat<?php the_field('media1_skill');?>"></span>
                </li>
                <li>
                	<h5><?php the_field('media2_name');?></h5>
                    <span class="rat<?php the_field('media2_skill');?>"></span>
               </li>
               <li>
               		<h5><?php the_field('media3_name');?></h5>
                	<span class="rat<?php the_field('media3_skill');?>"></span>
               </li>
               <li>
               		<h5><?php the_field('media4_name');?></h5>
                    <span class="rat<?php the_field('media4_skill');?>"></span>
               </li>
               <li>
               		<h5><?php the_field('media5_name');?></h5>
                    <span class="rat<?php the_field('media5_skill');?>"></span>
               </li>
          </ul>
          <h3 class="main-heading"><span>Programming Skills</span></h3>
          <ul class="skills">
              <li>
                  <h5><?php the_field('progl1_name');?></h5>
                  <span class="rat<?php the_field('progl1_skill');?>"></span>
              </li>
              <li>
                  <h5><?php the_field('progl2_name');?></h5>
                  <span class="rat<?php the_field('progl2_skill');?>"></span>
             </li>
             <li>
                  <h5><?php the_field('progl3_name');?></h5>
                  <span class="rat<?php the_field('progl3_skill');?>"></span>
             </li>
        </ul>
       	<h3 class="main-heading"><span>Design Skills</span></h3>
        <ul class="skills">
            	<li>
                	<h5><?php the_field('skill1');?></h5>
                    <span class="rat<?php the_field('skill1_level');?>"></span>
                </li>
                <li>
                	<h5><?php the_field('skill2');?></h5>
                    <span class="rat<?php the_field('skill2_level');?>"></span>
               </li>
               <li>
               		<h5><?php the_field('skill3');?></h5>
                	<span class="rat<?php the_field('skill3_level');?>"></span>
               </li>
          </ul> 
      </div>
     </div>
	<div id="vcard-portfolio" class="vcard-section">
    <center><h2>Some of the projects i'm proud with</h2></center><hr />
    	<ul class="portfolio-list">
          <li><br />
           <img src="<?php the_field('work1_img');?>" /><br />
            <span class="title"><?php the_field('work1');?></span><br />
            <span class="work-in"><?php the_field('work1_in');?></span><br />
            <a href="<?php the_field('work1_link');?>">Link</a><br />
            <span class="about"><?php the_field('work1_about');?></span><br />
            </li>
          <li>
            <img src="<?php the_field('work2_img');?>" /><br />
            <span class="title"><?php the_field('work2');?></span><br />
            <span class="work-in"><?php the_field('work2_in');?></span>   <br />
            <a href="<?php the_field('work2_link');?>">Link</a><br />
            <span class="about"><?php the_field('work2_about');?></span><br />
            </li>
          <li>
           <img src="<?php the_field('work3_img');?>" /><br />
            <span class="title"><?php the_field('work3');?></span><br />
            <span class="work-in"><?php the_field('work3_in');?></span><br />
            <a href="<?php the_field('work3_link');?>">Link</a><br />
            <span class="about"><?php the_field('work3_about');?></span><br />
            </li>
        </ul>
    </div>
    <div id="vcard-contactme" class="vcard-section grid col-940 fit">
    	 <div id="map" style="width:100%;height:400px;position:relative;"></div>   
    </div> 
  </div> 
  	<?php comments_template( '', true ); ?>
  <?php get_footer('vcard'); ?> 
 