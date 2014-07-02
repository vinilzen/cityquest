<?php

// this contains the application parameters that can be maintained via GUI
return array(
	// this is displayed in the header section
	'title'=>'City Quest',
	// this is used in error pages
	'adminEmail'=>'marchukilya@gmail.com',
	// number of posts displayed per page
	'postsPerPage'=>10,
	// maximum number of comments that can be displayed in recent comments portlet
	'recentCommentCount'=>10,
	// maximum number of tags that can be displayed in tag cloud portlet
	'tagCloudCount'=>20,
	// whether post comments need to be approved before published
	'commentNeedApproval'=>true,
	// the copyright information displayed in the footer section
	'copyrightInfo'=>'Copyright &copy; 2009 by Pandra ru.',

	// цена в будние до обеда
	'price_workday_AM' => 2000,
	
	// цена в будние после обеда
	'price_workday_PM' => 3000,

	// цена в выходные до обеда
	'price_weekend_AM' => 3000,

	// цена в выходные после обеда
	'price_weekend_PM' => 3500,
);
