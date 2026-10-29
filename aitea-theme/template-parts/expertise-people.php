<?php
$heading    = isset( $args['heading'] ) ? $args['heading'] : '';
$eyebrow    = isset( $args['eyebrow'] ) ? $args['eyebrow'] : '';
$subheading = isset( $args['subheading'] ) ? $args['subheading'] : '';
$people     = isset( $args['people'] ) && is_array( $args['people'] ) ? $args['people'] : array();
$variant    = isset( $args['variant'] ) ? $args['variant'] : '';
$id         = isset( $args['id'] ) ? $args['id'] : '';
?>
<section<?php echo $id ? ' id="' . esc_attr( $id ) . '"' : ''; ?> class="expertise-people content-section<?php echo $variant ? ' content-section--' . esc_attr( $variant ) : ''; ?>" aria-labelledby="<?php echo esc_attr( $id ? $id . '-title' : 'expertise-people-title' ); ?>">
    <div class="content-section__inner">
        <p class="eyebrow"><?php echo esc_html( aitea__( $eyebrow ) ); ?></p>
        <h2 id="<?php echo esc_attr( $id ? $id . '-title' : 'expertise-people-title' ); ?>"><?php echo esc_html( aitea__( $heading ) ); ?></h2>
        <p class="expertise-people__subheading"><?php echo esc_html( aitea__( $subheading ) ); ?></p>
        <div class="person-grid">
            <?php foreach ( $people as $person ) : ?>
                <?php get_template_part( 'template-parts/person-card', null, array( 'person' => $person ) ); ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
