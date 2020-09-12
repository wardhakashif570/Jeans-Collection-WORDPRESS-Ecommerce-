<?php
/*
 * Name: Hero
 * Section: content
 * Description: Image, title, text and call to action all in one
 */

/* @var $options array */
/* @var $wpdb wpdb */

$defaults = array(
    'title' => 'An Awesome Title',
    'text' => 'This is just a simple text you should change',
    'font_family' => 'Helvetica, Arial, sans-serif',
    'font_size' => 18,
    'font_weight' => 'normal',
    'font_color' => '#000000',
    'title_font_family' => 'Helvetica, Arial, sans-serif',
    'title_font_size' => '32',
    'title_font_weight' => 'bold',
    'title_font_color' => '#000000',
    'block_background' => '#ffffff',
    'layout' => 'full',
    'button_url' => '',
    'button_label' => 'Click Here',
    'button_font_color' => '#ffffff',
    'button_font_weight' => 'bold',
    'button_font_size' => 20,
    'button_background' => '#256F9C',
    'layout' => 'full',
    'block_padding_top'=>30,
    'block_padding_bottom'=>30,
    'block_padding_left'=>15,
    'block_padding_right'=>15
);

$options = array_merge($defaults, $options);

if (!empty($options['schema'])) {
    if ($options['schema'] === 'dark') {
        $options['block_background'] = '#000000';
        $options['title_font_color'] = '#ffffff';
        $options['font_color'] = '#ffffff';
        $options['button_font_color'] = '#ffffff';
        $options['button_background'] = '#96969C';
    }
    
    if ($options['schema'] === 'bright') {
        $options['block_background'] = '#ffffff';
        $options['title_font_color'] = '#000000';
        $options['font_color'] = '#000000';
        $options['button_font_color'] = '#ffffff';
        $options['button_background'] = '#256F9C';
    }
}

$layout = $options['layout'];

if ($layout == 'full') {
    $options = array_merge(array('block_padding_left'=>0, 'block_padding_right'=>0), $options);
} else {
    $options = array_merge(array('block_padding_left'=>15, 'block_padding_right'=>15), $options);
}
$url = $options['button_url'];

$font_family = $options['font_family'];
$font_size = $options['font_size'];
$font_weight = $options['font_weight'];
$font_color = $options['font_color'];

$title_font_family = $options['title_font_family'];
$title_font_size = $options['title_font_size'];
$title_font_weight = $options['title_font_weight'];
$title_font_color = $options['title_font_color'];

$layout = $options['layout'];

if (!empty($options['image']['id'])) {
    if ($layout == 'full') {
        $media = tnp_resize($options['image']['id'], array(600, 0));
    } else {
        $media = tnp_resize($options['image']['id'], array(300, 200, true));
    }
    $media->alt = $options['title'];
} else {
    $media = false;
}
?>

<?php if ($layout == 'full') { ?>

    <style>
        .hero-title {
            font-size: <?php echo $title_font_size ?>px; 
            color: <?php echo $title_font_color ?>; 
            font-family: <?php echo $title_font_family ?>;
            font-weight: <?php echo $title_font_weight ?>; 
        }
        .hero-text {
            padding: 20px 0 0 0; 
            font-size: <?php echo $font_size ?>px; 
            line-height: 150%; 
            color: <?php echo $font_color ?>; 
            font-family: <?php echo $font_family ?>; 
        }
        .hero-image {
            max-width: 100%!important; 
            display: block;
            border: 0px;
        }   
    </style>


    <!-- HERO IMAGE -->
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <?php if ($media) { ?>
        <tr>
            <td class="padding-copy tnpc-row-edit">
                <a href="<?php echo $url ?>" target="_blank" rel="noopener nofollow">
                    <img src="<?php echo $media->url ?>" border="0" alt="<?php echo esc_attr($media->alt) ?>" width="<?php echo $media->width ?>" height="<?php echo $media->height ?>" inline-class="hero-image">
                </a>
            </td>
        </tr>
        <?php } ?>
        <tr>
            <td>
                <!-- COPY -->
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" inline-class="hero-title">
                            <span><?php echo $options['title'] ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" inline-class="hero-text">
                            <span><?php echo $options['text'] ?></span>
                        </td>
                    </tr>

                    <tr>
                        <td align="center">
                            <br>
                            <?php echo tnpc_button($options)?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

<?php } ?>

<?php if ($layout == 'left') { ?>

    <style>
        .hero-title {
            font-size: <?php echo $title_font_size ?>px; 
            color: #333333; 
            padding-top: 0; 
            font-family: <?php echo $title_font_family ?>;
            font-weight: <?php echo $title_font_weight ?>; 
        }
        .hero-text {
            padding: 20px 0 0 0; 
            font-size: <?php echo $font_size ?>px; 
            line-height: 150%; 
            color: #666666; 
            font-family: <?php echo $font_family ?>; 
            font-weight: <?php echo $font_weight ?>; 
        }
    </style>

    <table width="290" align="left" class="hero-table">
        <tr>
            <td align="center" valign="top">
                <img src="<?php echo $media->url ?>" border="0" alt="<?php echo esc_attr($media->alt) ?>" width="<?php echo $media->width ?>" height="<?php echo $media->height ?>" style="max-width: 100%!important; height: auto!important; display: block;" class="img-max">                
            </td>
        </tr>
    </table>

    <table width="290" align="right" class="hero-table hero-table-right">
        <tr>
            <td align="center" style="text-align: center">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" inline-class="hero-title">
                            <span><?php echo $options['title'] ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" inline-class="hero-text">
                            <span><?php echo $options['text'] ?></span>
                        </td>
                    </tr>
                </table>
                <br>
               <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
                  <tr>
                    <td align="center" vertical-align="middle" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                        
                            <?php echo tnpc_button($options)?>
                    </td>
                  </tr>
               </table>
                      

            </td>
        </tr>
    </table>


<?php } ?>

