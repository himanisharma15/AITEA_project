<section class="expertise-intro content-section" aria-labelledby="expertise-title">
    <div class="content-section__inner">
        <?php
        get_template_part(
            'template-parts/breadcrumb',
            null,
            array(
                'items' => array(
                    array( 'label' => 'Home', 'url' => function_exists( 'pll_home_url' ) ? pll_home_url() : home_url( '/' ) ),
                    array( 'label' => 'Expertise' ),
                ),
            )
        );
        ?>
        <p class="eyebrow"><?php echo esc_html( aitea__( 'Expertise' ) ); ?></p>
        <h1 id="expertise-title"><?php echo esc_html( aitea__( 'Many perspectives.' ) ); ?><br><?php echo esc_html( aitea__( 'One shared purpose.' ) ); ?></h1>
        <p class="expertise-intro__lead"><?php echo esc_html( aitea__( 'Good exchange brings different experiences to the table. Meet the people-focused structure behind our work.' ) ); ?></p>
    </div>
</section>
