<?php
/* OPTIONS FOR BUTTONS SHORTCODE */
$shortcodesES['buttons'] = array(
	'params' => array(
		'content' => array(
			'std' => 'Button Label',
			'type' => 'text',
			'label' => __('Button\'s Label', TSC_DOMAIN),
			'desc' => __('Add the button\'s label', TSC_DOMAIN),
		),
		'type' => array(
			'type' => 'select',
			'label' => __('Button Type', TSC_DOMAIN),
			'desc' => __('Select the button\'s type', TSC_DOMAIN),
			'options' => array(
				'basic' => 'Basic',
				'primary' => 'Primary',
				'info' => 'Info',
				'success' => 'Success',
				'danger' => 'Danger',
				'warning' => 'Warning',
				'inverse' => 'Inverse',
			)
		),
		'size' => array(
			'type' => 'select',
			'label' => __('Button Size', TSC_DOMAIN),
			'desc' => __('Select the button\'s size', TSC_DOMAIN),
			'options' => array(
				'large' => 'Large',
				'medium' => 'Medium',
				'small' => 'Small',
				'mini' => 'Mini'
			)
		),
		'link' => array(
			'std' => '#',
			'type' => 'text',
			'label' => __('Button URL', TSC_DOMAIN),
			'desc' => __('Add the button\'s url eg http://example.com', TSC_DOMAIN)
		)
	),
	'templ_shortcode' => '[templatic_button link="{{link}}" size="{{size}}" type="{{type}}"] {{content}} [/templatic_button]',
	'popup_title' => __('Insert Button Shortcode', TSC_DOMAIN)
);
/* END OF BUTTONS */

/* OPTIONS FOR COLUMN SHORTCODE */
$shortcodesES['column'] = array(
	'params' => array(
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Column Title', TSC_DOMAIN),
			'desc' => __('Mention the title of the column', TSC_DOMAIN)
		),
		'layout' => array(
			'type' => 'select',
			'label' => __('Column Layout', TSC_DOMAIN),
			'desc' => __('Select the column layout', TSC_DOMAIN),
			'options' => array(
				'one_half' => 'One Half',
				'one_half_last' => 'One Half Last',
				'one_third' => 'One Third',
				'one_third_last' => 'One Third Last',
				'one_fourth' => 'One Fourth',
				'one_fourth_last' => 'One Fourth Last',
				'two_third' => 'Two Third',
				'two_third_last' => 'Two Third Last'
			)
		),
		'content' => array(
			'std' => 'Column Content',
			'type' => 'textarea',
			'label' => __('Column\'s Content', TSC_DOMAIN),
			'desc' => __('Add the column\'s content', TSC_DOMAIN),
		)
	),
	'templ_shortcode' => '[templatic_columns layout="{{layout}}" title="{{title}}"] {{content}} [/templatic_columns]',
	'popup_title' => __('Insert Column Shortcode', TSC_DOMAIN)
);
/* END OF COLUMN */

/* OPTIONS FOR MSG BOX */
$shortcodesES['msg_box'] = array(
	'params' => array(
		'type' => array(
			'type' => 'select',
			'label' => __('Message Type', TSC_DOMAIN),
			'desc' => __('Select the message type', TSC_DOMAIN),
			'options' => array(
				'alert' => 'Alert',
				'error' => 'Error',
				'success' => 'Success',
				'info' => 'Information'
			)
		),
		'content' => array(
			'std' => 'Add Content',
			'type' => 'textarea',
			'label' => __('Add Content', TSC_DOMAIN),
			'desc' => __('Add the content for message box', TSC_DOMAIN),
		)
	),
	'templ_shortcode' => '[templatic_msg_box type="{{type}}"] {{content}} [/templatic_msg_box]',
	'popup_title' => __('Insert Message Box Shortcode', TSC_DOMAIN)
);
/* END OF MSG BOX */


/* OPTIONS FOR LABEL/BADGE */
$shortcodesES['label'] = array(
	'params' => array(
		'content' => array(
			'std' => 'Label/Badge Title',
			'type' => 'text',
			'label' => __('Label/Badge Title', TSC_DOMAIN),
			'desc' => __('Add a title for label/badge', TSC_DOMAIN),
		),
		'type' => array(
			'type' => 'select',
			'label' => __('Select Type', TSC_DOMAIN),
			'desc' => __('Select the type whether you want to create shortcode for label or a badge', TSC_DOMAIN),
			'options' => array(
				'label' => 'Label',
				'badge' => 'Badge'
			)
		),
		'class' => array(
			'type' => 'select',
			'label' => __('Label/Badge Class', TSC_DOMAIN),
			'desc' => __('Select the class for label/badge', TSC_DOMAIN),
			'options' => array(
				'default' => 'Default',
				'success' => 'Success',
				'warning' => 'Warning',
				'important' => 'Important',
				'info' => 'Information',
				'inverse' => 'Inverse'
			)
		),
	),
	'templ_shortcode' => '[templatic_label type="{{type}}" class="{{class}}"] {{content}} [/templatic_label]',
	'popup_title' => __('Insert Label/Badge Shortcode', TSC_DOMAIN)
);
/* END OF LABEL/BADGE */

/* OPTIONS FOR POPOVER */
$shortcodesES['popover'] = array(
	'params' => array(
		'content' => array(
			'std' => 'Insert Label',
			'type' => 'text',
			'label' => __('Insert Label', TSC_DOMAIN),
			'desc' => __('Give a label for the button', TSC_DOMAIN),
		),
		'placement' => array(
			'std' => 'Placement',
			'type' => 'select',
			'label' => __('Select placement', TSC_DOMAIN),
			'desc' => __('select the place to display the popover', TSC_DOMAIN),
			'options' => array(
				'top' => 'Top',
				'bottom' => 'Bottom',
				'left' => 'Left',
				'right' => 'Right')
		),
		'data_original_title' => array(
			'std' => 'Add Title',
			'type' => 'text',
			'label' => __('Add Title', TSC_DOMAIN),
			'desc' => __('Add the title to display in the popover', TSC_DOMAIN),
		),
		'data_content' => array(
			'std' => 'Add Content',
			'type' => 'textarea',
			'label' => __('Add Content', TSC_DOMAIN),
			'desc' => __('Add the content to display in the popover', TSC_DOMAIN),
		)
	),
	'templ_shortcode' => '[templatic_popover data_content="{{data_content}}" data_original_title="{{data_original_title}}" placement="{{placement}}"] {{content}} [/templatic_popover]',
	'popup_title' => __('Insert Popover Shortcode', TSC_DOMAIN)
);
/* END OF POPOVER */

/* OPTIONS FOR SCROLL */
$shortcodesES['modal'] = array(
	'params' => array(
		'button_link' => array(
			'std' => 'Link Label',
			'type' => 'text',
			'label' => __('Link Label', TSC_DOMAIN),
			'desc' => __('Add the label for the link', TSC_DOMAIN),
		),
		'content' => array(
			'std' => 'Modal Content',
			'type' => 'textarea',
			'label' => __('Modal Content', TSC_DOMAIN),
			'desc' => __('Insert the content to display in the popup', TSC_DOMAIN),
		)
	),
	'templ_shortcode' => '[templatic_modal button_link="{{button_link}}"] {{content}} [/templatic_modal]',
	'popup_title' => __('Insert Modal Shortcode', TSC_DOMAIN)
);
/* END OF MODAL */

/* OPTIONS FOR SCROLL */
$shortcodesES['scroll'] = array(
	'params' => array(
		'content' => array(
			'std' => 'Insert Content',
			'type' => 'textarea',
			'label' => __('Insert Content', TSC_DOMAIN),
			'desc' => __('Add the content to display in the scroll', TSC_DOMAIN),
		)
	),
	'templ_shortcode' => '[templatic_scroll] {{content}} [/templatic_scroll]',
	'popup_title' => __('Insert Scroll Shortcode', TSC_DOMAIN)
);
/* END OF SCROLL */

/* OPTIONS FOR TOOLTIP */
$shortcodesES['tooltip'] = array(
	'params' => array(),
    'templ_shortcode' => '[templatic_tooltip] {{child_shortcode}} [/templatic_tooltip]',
	'popup_title' => __('Insert Tooltip Shortcode', TSC_DOMAIN),
    
    'child_shortcode' => array(
        'params' => array(
			'content' => array(
				'std' => 'Link Label',
				'type' => 'text',
				'label' => __('Link Label', TSC_DOMAIN),
				'desc' => __('Add the label of the link on which you wish to display the tooltip', TSC_DOMAIN),
			),
			'position' => array(
				'std' => 'Position',
				'type' => 'select',
				'label' => __('Mention Position', TSC_DOMAIN),
				'desc' => __('Mention the position of the tooltip', TSC_DOMAIN),
				'options' => array(
					'top' => 'Top',
					'left' => 'Left',
					'bottom' => 'Bottom',
					'right' => 'Right')
			),
			'text' => array(
				'std' => 'Tooltip Content',
				'type' => 'textarea',
				'label' => __('Tooltip Content', TSC_DOMAIN),
				'desc' => __('Add Tooltip Content', TSC_DOMAIN),
			)
		),
        'shortcode' => '[tooltip_li position="{{position}}" text="{{text}}"] {{content}} [/tooltip_li]',
        'clone_button' => __('Add Tab', TSC_DOMAIN)
    )
);
/* END OF TOOLTIP */

/* OPTIONS FOR CONTENT BOX */
$shortcodesES['content_box'] = array(
	'params' => array(
		'title' => array(
			'std' => 'Box title',
			'type' => 'text',
			'label' => __('Box title', TSC_DOMAIN),
			'desc' => __('Mention the title for the content box', TSC_DOMAIN),
		),
		'type' => array(
			'type' => 'select',
			'label' => __('Content Box Type', TSC_DOMAIN),
			'desc' => __('Select the type for the box', TSC_DOMAIN),
			'options' => array(
				'normal' => 'Normal',
				'author' => 'Author',
				'warning' => 'Warning',
				'download' => 'Download',
				'info' => 'Information',
				'about' => 'About',
				'alert' => 'Alert'
			)
		),
		'content' => array(
			'std' => 'Add Content',
			'type' => 'textarea',
			'label' => __('Add Content', TSC_DOMAIN),
			'desc' => __('Add the content for the content box', TSC_DOMAIN),
		)
	),
	'templ_shortcode' => '[templatic_contentbox type="{{type}}" title="{{title}}"] {{content}} [/templatic_contentbox]',
	'popup_title' => __('Insert Content Box Shortcode', TSC_DOMAIN)
);
/* END OF CONTENT BOX */

/* OPTIONS FOR SMALL CONTENT BOX */
$shortcodesES['small_content_box'] = array(
	'params' => array(
		'title' => array(
			'std' => 'Box title',
			'type' => 'text',
			'label' => __('Box title', TSC_DOMAIN),
			'desc' => __('Mention the title for the content box', TSC_DOMAIN),
		),
		'type' => array(
			'type' => 'select',
			'label' => __('Content Box Type', TSC_DOMAIN),
			'desc' => __('Select the type for the box', TSC_DOMAIN),
			'options' => array(
				'about' => 'About',
				'info' => 'Information',
				'alert' => 'Alert'
			)
		),
		'content' => array(
			'std' => 'Add Content',
			'type' => 'textarea',
			'label' => __('Add Content', TSC_DOMAIN),
			'desc' => __('Add the content for content box', TSC_DOMAIN),
		)
	),
	'templ_shortcode' => '[templatic_smallcontentbox type="{{type}}" title="{{title}}"] {{content}} [/templatic_smallcontentbox]',
	'popup_title' => __('Insert Small Content Box Shortcode', TSC_DOMAIN)
);
/* END OF SMALL CONTENT BOX */

/* OPTIONS FOR DROPCAP */
$shortcodesES['dropcap'] = array(
	'params' => array(
		'color' => array(
			'type' => 'select',
			'label' => __('Select Color', TSC_DOMAIN),
			'desc' => __('Select the color for the letter', TSC_DOMAIN),
			'options' => array(
				'color1' => 'Color 1',
				'color2' => 'Color 2',
				'color3' => 'Color 3'
			)
		),
		'letter' => array(
			'std' => 'Letter',
			'type' => 'text',
			'label' => __('Letter', TSC_DOMAIN),
			'desc' => __('Mention the letter to use as dropcap', TSC_DOMAIN),
		),
		'content' => array(
			'std' => 'Add Content',
			'type' => 'textarea',
			'label' => __('Add Content', TSC_DOMAIN),
			'desc' => __('Add the content', TSC_DOMAIN),
		)
	),
	'templ_shortcode' => '[templatic_dropcaps color="{{color}}" letter="{{letter}}"] {{content}} [/templatic_dropcaps]',
	'popup_title' => __('Insert Dropcap Shortcode', TSC_DOMAIN)
);
/* END OF DROPCAP */

/* OPTIONS FOR PROGRESS BAR */
$shortcodesES['progressbar'] = array(
	'params' => array(
		'type' => array(
			'type' => 'select',
			'label' => __('Select Type', TSC_DOMAIN),
			'desc' => __('Select the type for the progress bar', TSC_DOMAIN),
			'options' => array(
				'normal' => 'Normal',
				'strip' => 'Strip',
				'strip_active' => 'Strip Active',
				'progress' => 'Progress'
			)
		),
		'percent' => array(
			'std' => '0',
			'type' => 'text',
			'label' => __('Percent', TSC_DOMAIN),
			'desc' => __('Mention the percent of the complated process. Insert only numeric value. You need to insert comma separated values in order to use the progress type progress bar.', TSC_DOMAIN),
		),
	),
	'templ_shortcode' => '[templatic_progressbar type="{{type}}" percent="{{percent}}"][/templatic_progressbar]',
	'popup_title' => __('Insert Progress Bar Shortcode', TSC_DOMAIN)
);
/*  END OF PROGRESS BAR */
/* OPTION FOR TAB */
$shortcodesES['accordion'] = array(
    'params' => array(),
    'templ_shortcode' => '[templatic_accordion] {{child_shortcode}}  [/templatic_accordion]',
    'popup_title' => __('Insert Accordion Shortcode', TSC_DOMAIN),
    
    'child_shortcode' => array(
        'params' => array(
            'title' => array(
                'std' => 'Title',
                'type' => 'text',
                'label' => __('Tab Title', TSC_DOMAIN),
                'desc' => __('Add title of the tab', TSC_DOMAIN),
            ),
            'content' => array(
                'std' => 'Add Content',
                'type' => 'textarea',
                'label' => __('Add Content', TSC_DOMAIN),
                'desc' => __('Add content the content', TSC_DOMAIN)
            )
        ),
        'shortcode' => '[accordion title="{{title}}"] {{content}} [/accordion]',
        'clone_button' => __('Add Tab', TSC_DOMAIN)
    )
);
/* END OF TAB */


/* OPTION FOR TAB */
$shortcodesES['tabs'] = array(
    'params' => array(),
    'templ_shortcode' => '[templatic_tabs] {{child_shortcode}}  [/templatic_tabs]',
    'popup_title' => __('Insert Tab Shortcode', TSC_DOMAIN),
    
    'child_shortcode' => array(
        'params' => array(
            'title' => array(
                'std' => 'Title',
                'type' => 'text',
                'label' => __('Tab Title', TSC_DOMAIN),
                'desc' => __('Add title of the tab', TSC_DOMAIN),
            ),
            'content' => array(
                'std' => 'Tab Content',
                'type' => 'textarea',
                'label' => __('Tab Content', TSC_DOMAIN),
                'desc' => __('Add content for the tab', TSC_DOMAIN)
            )
        ),
        'shortcode' => '[templatic_tab title="{{title}}"] {{content}} [/templatic_tab]',
        'clone_button' => __('Add Tab', TSC_DOMAIN)
    )
);
/* END OF TAB */

/* OPTION FOR ICONS */
$shortcodesES['icons'] = array(
	'params' => array(
		'type' => array(
			'type' => 'select',
			'label' => __('Select Type', TSC_DOMAIN),
			'desc' => __('Select the type for the icons', TSC_DOMAIN),
			'options' => array(
				'basic' => 'Basic',
				'cancel' => 'Cancel',
				'dot' => 'Dot')
		)),
    'templ_shortcode' => '[templatic_icons type="{{type}}"] {{child_shortcode}}  [/templatic_icons]',
    'popup_title' => __('Insert Icons Shortcode', TSC_DOMAIN),
    
    'child_shortcode' => array(
		'params' => array(
			'content' => array(
			'std' => 'Add List Label',
			'type' => 'textarea',
			'label' => __('Add List Label', TSC_DOMAIN),
			'desc' => __('Add the list label. You can add multiple lists by using HTML tags in this area', TSC_DOMAIN),
		)),
        'shortcode' => '[LI] {{content}} [/LI]',
        'clone_button' => __('Add List', TSC_DOMAIN)
    )
);
/* END OF ICONS */

$shortcodesES['mentieslist'] = array(
    'templ_shortcode' => '[ame_list] {{child_shortcode}}  [/ame_list]',
    'popup_title' => __('Insert menties list Shortcode', TSC_DOMAIN),
    
    'child_shortcode' => array(
		'params' => array(
			'content' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __('Add The List', TSC_DOMAIN),
			'desc' => __('Add the list using [yes][/yes] and [no][/no] shortcodes.', TSC_DOMAIN),
		)),
        'shortcode' => '{{content}}',
        'clone_button' => __('Add List', TSC_DOMAIN)
    )
);
?>