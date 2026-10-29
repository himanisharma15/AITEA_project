<?php if ( defined( 'AITEA_DEMO_CONTENT' ) && AITEA_DEMO_CONTENT ) : ?>
<section class="content-section expertise-notice-section" aria-label="<?php echo esc_attr( aitea__( 'Content notice' ) ); ?>">
    <div class="content-section__inner">
        <div class="aitea-notice aitea-notice--info">
            <?php echo aitea_icon( 'info' ); ?>
            <p><?php echo esc_html( aitea__( 'All Board and Advisor profiles below are illustrative samples, not confirmed AITEA appointments. Names, roles and biographies require verification before publication.' ) ); ?></p>
        </div>
    </div>
</section>
<?php endif; ?>
