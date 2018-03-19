(function ($) {
$(document).ready(function() {
//	$('.breadcrumb li:first-child a').html('ITS');

//	$(".region-header .globalnav ul li ul").prev().addClass("parent");

	var images = [
		'CSIkickoff-1920.jpg', 
		'UMAngellHall.jpg', 
		'UMAngellHallFront.jpg', 
		'UMCampusSidewalk.jpg', 
		'UMCube.jpg', 
	//	'UMHillAuditorium.jpg', 
		'UMIngallsMallFountain.jpg', 
		'UMMuseumofArt.jpg', 
		'UMRackham.jpg', 
		'UMstadium.jpg', 
		'UMStuCampus.jpg', 
		'UMtoDiag.jpg', 
		'UMComputerRepair.jpg', 
		'UMArborLakesWinter.jpg', 
	//	'UMAngellHallComputingCenter.jpg', 
	//	'NCampus.jpg',
	//	'NCampusBellTower.jpg', 
		'NCampusStairway.jpg', 
		'NCampusFountain.jpg',
		'UMWinterStock_1920x1280.jpg',
		'UMCampusBldgStock_1920x1280.jpg',
		'UMAerialsJuly15_1920x1280.jpg',
		'ReadRoomDetails_1920x1280.jpg',
		'DiagM_1920x1280.jpg',
	//	'UMCampusBldgStock12_014_1920x1280.jpg',
		'UMStockMiscCampus13_80_1920x1280.jpg',
		'SummrStock15_030_1920x1280.jpg',
		'UMUnionBldgDusk_1920x1280.jpg',
		'UMSrvlFlghtMmrl_1920x1280.jpg',
		'UMPowerCenterReflection_1920x1280.jpg'
	];
	$('.region-header').css({'background-image': 'url(/sites/all/themes/bootstrap_its/images/' + images[Math.floor(Math.random() * images.length)] + ')'});
	$(".mobilebutton").click(function(){
		$(".region-header .globalnav ul").slideToggle("");
//		if($(".mobilebutton").attr("aria-expanded")) { $(".mobilebutton").removeAttr("aria-expanded"); } else { $(".mobilebutton").attr("aria-expanded", true); }
		$(".mobilebutton").attr("aria-expanded",$(this).attr("aria-expanded")==="true"?"false":"true");
	});
	$(window).resize(function(){
	//	$(".region-header .globalnav ul").removeAttr("style");
	});
	$(".region-header .globalnav").accessibleDropDown();

	$('div.region.region-sidebar-first.well .block-title').html($('div.region.region-sidebar-first.well .block-title').text().replace($('div.region.region-sidebar-first.well .block-title').text(), '<a href="javascript:link()">'+$('div.region.region-sidebar-first.well .block-title').text()+'</a>'));
	$("div.region.region-sidebar-first.well .block-title").attr("aria-expanded", false).attr("role", "button");
	$("div.region.region-sidebar-first.well .block-title").click(function(){
		$("div.region.region-sidebar-first.well ul.menu.nav").slideToggle("");
		$("div.region.region-sidebar-first.well .block-title").toggleClass('open');
		$("div.region.region-sidebar-first.well .block-title").attr("aria-expanded",$(this).attr("aria-expanded")==="true"?"false":"true");
	});
	$(window).resize(function(){
		$("div.region.region-sidebar-first.well ul.menu.nav").removeAttr("style");
	});

	$('a.dropdown-toggle').removeAttr('data-toggle');
	$('a.dropdown-toggle').removeAttr('data-target');

//	$("#block-views-home-page-data-circles-block .views-row").eq(0).addClass("fade_in two");
//	$("#block-views-home-page-data-circles-block .views-row").eq(1).addClass("fade_in one");
//	$("#block-views-home-page-data-circles-block .views-row").eq(2).addClass("fade_in three");

	$(".image-zoom").fancybox({
		'autoScale'	: true,
		'titleShow' : false,
		'onClosed': function() {
			$("#fancy-content").empty();
		}
	});
	$(".image-zoom-link").fancybox({
		'autoScale'	: true,
		'titleShow' : false,
		'onClosed'	: function() {
			$("#fancy-content").empty();
		}
	});
	$(".modal-info").fancybox({
		'type'		: 'iframe',
		'autoDimensions': false,
		'autoScale'	: false,
		'width'		: 840,
		'height'	: 640,
		'padding'	: 0,
		'scrolling'	: 'auto',
		'titleShow'     : false,
		'onClosed'	: function() {
			$("#fancy-content").empty();
		}
	});

	$("a[rel=gallery]").fancybox({
		'autoScale'	: true,
		'titleShow' : true,
		'titlePosition'	: 'inside',
		'onClosed': function() {
			$("#fancy-content").empty();
		}
	});
		
	$("#service-center-options-table").hide();
	$(".service-center-skip-recording .toggle-service-center-options").click(function() {
		$("#service-center-options-table").slideToggle();
		});

	$(".service-center-browsers-requirements .browser-requirement-exception").hide();
	$(".service-center-browsers-requirements .browser-requirement-title").click(function() {
		$(this).next(".browser-requirement-exception").slideToggle();
		$(this).toggleClass("open");
		});
	$(".view-id-its_communications_systems_data_centers_life_cycle .views-field-field-category-description").hide();
	$(".view-id-its_communications_systems_data_centers_life_cycle .views-field-title").click(function() {
		$(this).next(".views-field-field-category-description").slideToggle();
		$(this).toggleClass("open");
		});
	$(".views-field-field-category-description a").fancybox({
		'autoScale'	: false,
		'titleShow'     : true,
		'titlePosition'	: 'over',
		'onClosed'	: function() {
			$("#fancy-content").empty();
		}
	});
	
	$(".field-name-field-faq-expanded-text").prev().addClass("field-name-field-faq-initial-text-clickable");
	$(".field-name-field-faq-expanded-text").prev().removeClass("field-name-field-faq-initial-text");
	$(".field-name-field-faq-expanded-text").hide();
	$(".field-name-field-faq-initial-text-clickable").click(function() {
		$(this).next(".field-name-field-faq-expanded-text").slideToggle();
		$(this).toggleClass("field-name-field-faq-initial-text-clickable-open");
		});

	$(".expand-all-content").click(function() {
		if($(this).html()=='Expand All Content') { $(".field-name-field-faq-initial-text-clickable").addClass("field-name-field-faq-initial-text-clickable-open").next().slideDown(); } else { $(".field-name-field-faq-initial-text-clickable-open").removeClass("field-name-field-faq-initial-text-clickable-open").next().slideUp(); }
		$(this).html($(this).html() == 'Hide All Content' ? 'Expand All Content' : 'Hide All Content');
		});


	//ITS PROJECT STATUS CONTACTS TOGGLE
	$(".project-status-contact-data").hide();
	$(".project-status-contact-button").click(function() {
		$(this).next(".project-status-contact-data").slideToggle();
		$(this).toggleClass("project-status-contact-button-open");
		});

	// MCommunity Individual Sponsorship Application	$("#edit-submitted-sponsor-ind-reason-for-sponsorship .form-radio").click(function(){		if($(this).val()=="Short-Term Guest"||$(this).val()=="Conference/Program Participant") {			$("#webform-component-sponsor-ind-existing-umid").hide();			$("#webform-component-sponsor-ind-existing-uniqname").hide();			$("#webform-component-sponsor-ind-requested-uniqname-header").hide();
			$("#webform-component-sponsor-ind-uniqname-first-choice").hide();
			$("#webform-component-sponsor-ind-uniqname-second-choice").hide();
			$("#webform-component-sponsor-ind-uniqname-third-choice").hide();
		} else {			$("#webform-component-sponsor-ind-existing-umid").show();			$("#webform-component-sponsor-ind-existing-uniqname").show();			$("#webform-component-sponsor-ind-requested-uniqname-header").show();
			$("#webform-component-sponsor-ind-uniqname-first-choice").show();
			$("#webform-component-sponsor-ind-uniqname-second-choice").show();
			$("#webform-component-sponsor-ind-uniqname-third-choice").show();
		}		if($(this).val()=="Long-Term Guest"||$(this).val()=="Short-Term Guest"||$(this).val()=="Conference/Program Participant") {			$("#webform-component-sponsor-ind-date-of-birth").hide();			$("#webform-component-sponsor-ind-gender").hide();			$("#webform-component-sponsor-ind-home-street-address").hide();			$("#webform-component-sponsor-ind-city").hide();			$("#webform-component-sponsor-ind-state-province").hide();			$("#webform-component-sponsor-ind-zip-postal-code").hide();			$("#webform-component-sponsor-ind-country").hide();			$("#webform-component-sponsor-ind-telephone-number").hide();		} else {			$("#webform-component-sponsor-ind-date-of-birth").show();			$("#webform-component-sponsor-ind-gender").show();			$("#webform-component-sponsor-ind-home-street-address").show();			$("#webform-component-sponsor-ind-city").show();			$("#webform-component-sponsor-ind-state-province").show();			$("#webform-component-sponsor-ind-zip-postal-code").show();			$("#webform-component-sponsor-ind-country").show();			$("#webform-component-sponsor-ind-telephone-number").show();		}	});
	
	//SHIBBOLETH CONFIGURATION REQUEST
	$("#edit-submitted-shibboleth-config-saml-oidc .form-radio").click(function(){
		//alert('Shibboleth');
		if($(this).val()=="OIDC") {
			$(".form-item-submitted-shibboleth-config-login-ids-select-select-or-other").hide();
			$("#webform-component-shibboleth-config-entity-id").hide();
			$("#webform-component-shibboleth-config-metadata-url").hide();
			$("#webform-component-shibboleth-config-metadata-file-link").hide();
			$("#webform-component-shibboleth-config-connection-method").hide();
			$("#webform-component-attributes-h3").hide();
			$("#webform-component-shibboleth-config-additional-attributes").hide();
			$("#webform-component-organizations-federations-that-need-access").hide();
			$("#webform-component-shibboleth-config-redirect-uri").show();
		} else {
			$(".form-item-submitted-shibboleth-config-login-ids-select-select-or-other").show();
			$("#webform-component-shibboleth-config-entity-id").show();
			$("#webform-component-shibboleth-config-metadata-url").show();
			$("#webform-component-shibboleth-config-metadata-file-link").show();
			$("#webform-component-shibboleth-config-connection-method").show();
			$("#webform-component-attributes-h3").show();
			$("#webform-component-shibboleth-config-additional-attributes").show();
			$("#webform-component-organizations-federations-that-need-access").show();
			$("#webform-component-shibboleth-config-redirect-uri").hide();
		}
	});

	//TABLE FILTERS
	$('.view-umtv-channel-lineup table').filterTable({ // apply filterTable to all tables on this page
		inputSelector: '#umtv-channel-input-filter'
		});
	$('.view-iptv-channel-lineup table').filterTable({ // apply filterTable to all tables on this page
		inputSelector: '#iptv-channel-input-filter'
		});
	$('.view-iptv-channel-lineup-block table').filterTable({ // apply filterTable to all tables on this page
		inputSelector: '#iptv-channel-input-filter'
		});
	$('.view-blue-jeans-units-view table').filterTable({ // apply filterTable to all tables on this page
		inputSelector: '#blue-jeans-unit-input-filter'
		});
	$('.view-its-comm-project-managers-executive-contacts table.cols-5').filterTable({ // apply filterTable to all tables on this page
		inputSelector: '#its-project-managers-input-filter'
		});
	$('#campus-building-network-connections').filterTable({
		inputSelector: '#campus-building-network-connections-input-filter'
		});
	$('#infrastructure-rates-table').filterTable({
		inputSelector: '#infrastructure-rates-input-filter'
		});
	$('#intl-long-distance-rates table').filterTable({
		inputSelector: '#intl-long-distance-input-filter'
		});
	$('#canada-long-distance-rates table').filterTable({
		inputSelector: '#canada-long-distance-input-filter'
		});
	$('#mexico-long-distance-rates table').filterTable({
		inputSelector: '#mexico-long-distance-input-filter'
		});		
	$('#island-long-distance-rates table').filterTable({
		inputSelector: '#island-long-distance-input-filter'
		});
	$('.view-unit-liaison-list table.cols-6').filterTable({
		inputSelector: '#unit-liaison-input-filter'
		});

});
$.fn.accessibleDropDown = function ()
{
	var el = $(this);
	$("a", el).focus(function() {
		$(this).parents("li").addClass("hover");
		$(this).parents("li").setAttribute("aria-expanded", true);
	}).blur(function() {
		$(this).parents("li").removeClass("hover");
		$(this).parents("li").setAttribute("aria-expanded", false);
	});
}
console.log('%c Go Blue! ', 'background: #00274c; color: #ffcb05; font-family:border:1px solid #00274c; border-radius:3px;padding:3px;');
})(jQuery);

function link() {}

setTimeout(function(){var a=document.createElement("script");
var b=document.getElementsByTagName("script")[0];
a.src=document.location.protocol+"//script.crazyegg.com/pages/scripts/0054/2162.js?"+Math.floor(new Date().getTime()/3600000);
a.async=true;a.type="text/javascript";b.parentNode.insertBefore(a,b)}, 1);
