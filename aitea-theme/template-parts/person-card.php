<?php
$person = isset( $args['person'] ) && is_array( $args['person'] ) ? $args['person'] : array();
if ( empty( $person['name'] ) ) {
    return;
}
$has_image = ! empty( $person['image'] );
$image_url = $has_image && is_numeric( $person['image'] ) ? wp_get_attachment_image_url( (int) $person['image'], 'thumbnail' ) : ( $has_image ? $person['image'] : '' );
$show_sample = ! empty( $person['sample'] ) && defined( 'AITEA_DEMO_CONTENT' ) && AITEA_DEMO_CONTENT;
?>
<article class="person-card">
    <div class="person-card__top">
        <div class="person-card__avatar">
            <?php if ( $image_url ) : ?>
                <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $person['name'] ); ?>" width="84" height="84" loading="lazy">
            <?php else : ?>
                <span aria-hidden="true"><?php echo esc_html( $person['initials'] ?? '' ); ?></span>
            <?php endif; ?>
        </div>
        <?php if ( $show_sample ) : ?>
            <span class="person-card__badge"><?php echo esc_html( aitea__( 'Sample profile' ) ); ?></span>
        <?php endif; ?>
    </div>
    <h3><?php echo esc_html( $person['name'] ); ?></h3>
    <p class="person-card__focus"><?php echo esc_html( $person['focus'] ?? '' ); ?></p>
    <p class="person-card__description"><?php echo esc_html( $person['description'] ?? '' ); ?></p>
    <?php if ( ! empty( $person['tags'] ) ) : ?>
        <ul class="person-card__tags">
            <?php foreach ( $person['tags'] as $tag ) : ?>
                <li><?php echo esc_html( $tag ); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</article>
