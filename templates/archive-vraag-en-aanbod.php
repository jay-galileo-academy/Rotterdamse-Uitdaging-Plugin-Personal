<?php get_header(); ?>

<div class="vea-wrapper">
    <div class="vea-wrapper__inner grid-1-3">

        <div class="vea-sidebar">
            <div class="aanmelden">
                <p>Heb jij een vraag of aanbod?</p> <p>Gebruik dan de knop hier onder om deze aan te melden</p>
                <a href="/vraag-en-aanbod-registreren/">Nieuwe vraag/aanbod</a>
            </div>
            <?php echo do_shortcode('[fe_widget]'); ?>
        </div>
        <div class="vea-main">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

            <?php $current_post = get_the_ID(); ?>
            <?php $type = get_post_meta($current_post, '_vraag_en_aanbod_type', true); ?>
            <?php $status = get_post_meta($current_post, '_vraag_en_aanbod_status', true); ?>
            <?php $categorie = get_post_meta($current_post, '_vraag_en_aanbod_categorie', true); ?>
            <?php $organisatie = get_post_meta( $current_post, '_vraag_en_aanbod_organisatie', true ); ?>
            <?php $beschrijving = get_post_meta( $current_post, '_vraag_en_aanbod_beschrijving', true ); ?>
            <?php if (has_post_thumbnail($current_post)) {
                $thumbnail = get_the_post_thumbnail_url($current_post);
            } else {
                $thumbnail = plugin_dir_url(__FILE__) . '../assets/images/placeholder-vraag-en-aanbod.jpg';
            } ?>


            <a class="vea-container" href="<?php the_permalink(); ?>">
                <div class="image-container">
                    <img src="<?php echo $thumbnail ?>" alt="">
                </div>
                <div class="content">
                    <h4><?php the_title(); ?></h4>
                    <p><?php echo $beschrijving ?></p>
                    <div class="meta">
                        <p><span class="capitalize"><?php echo $type ?></span> voor de <span class="capitalize"><?php echo $categorie ?></span></p>
                        <p>Door <span class="capitalize"><?php echo $organisatie ?></span> op <span class="capitalize"><?php echo get_the_date(); ?></span></p>
                        <p>Status: <span class="capitalize"><?php echo $status ?></span></p>
                    </div>
                </div>
            </a>

            <?php endwhile; else : ?>
                <p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
            <?php endif; ?>
            <div class="vea-pagination">
                <?php the_posts_pagination(); ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>