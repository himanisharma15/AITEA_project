<?php
$items = isset( $args['items'] ) && is_array( $args['items'] ) ? $args['items'] : array();
if ( empty( $items ) ) {
    return;
}
?>
<nav class="breadcrumb" aria-label="<?php echo esc_attr( aitea__( 'Breadcrumb' ) ); ?>">
    <ol>
        <?php foreach ( $items as $index => $item ) : ?>
            <?php $is_current = ( count( $items ) - 1 === $index ); ?>
            <li>
                <?php if ( ! $is_current && ! empty( $item['url'] ) ) : ?>
                    <a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( aitea__( $item['label'] ) ); ?></a>
                <?php else : ?>
                    <span<?php echo $is_current ? ' aria-current="page"' : ''; ?>><?php echo esc_html( aitea__( $item['label'] ) ); ?></span>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ol>
</nav>