<section class="objectives-intro content-section" aria-labelledby="objectives-title">
    <div class="content-section__inner">
        <?php
        get_template_part(
            'template-parts/breadcrumb',
            null,
            array(
                'items' => array(
                    array( 'label' => 'Home', 'url' => function_exists( 'pll_home_url' ) ? pll_home_url() : home_url( '/' ) ),
                    array( 'label' => 'Objectives' ),
                ),
            )
        );
        ?>
        <p class="eyebrow"><?php echo esc_html( aitea__( 'Objectives' ) ); ?></p>
        <h1 id="objectives-title"><?php echo esc_html( aitea__( 'Six fields. Countless possibilities.' ) ); ?></h1>
        <p class="objectives-intro__lead"><?php echo esc_html( aitea__( 'From a shared idea to a shared experience: our objectives connect Austrian and Indian talent across the things that move us forward.' ) ); ?></p>
    </div>
</section>
