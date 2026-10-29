<?php
$home_url = function_exists( 'pll_home_url' ) ? pll_home_url() : home_url( '/' );
?>
<section class="about-intro content-section" aria-labelledby="about-title">
    <div class="content-section__inner">
        <?php
        get_template_part(
            'template-parts/breadcrumb',
            null,
            array(
                'items' => array(
                    array( 'label' => 'Home', 'url' => $home_url ),
                    array( 'label' => 'About Us' ),
                ),
            )
        );
        ?>
        <p class="eyebrow"><?php echo esc_html( aitea__( 'About Us' ) ); ?></p>
        <h1 id="about-title"><?php echo esc_html( aitea__( 'A connection built on people.' ) ); ?></h1>
        <p class="about-intro__lead"><?php echo esc_html( aitea__( 'Austrian-Indian Talent Exchange Association. A Vienna-based nonprofit opening space for talent, dialogue and shared opportunity.' ) ); ?></p>
    </div>
</section>