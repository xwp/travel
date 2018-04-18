<?php
/**
 * This is a placeholder for search template.
 *
 * @package WPAMPTheme
 * @todo Create a proper template.
 */

// Ignore the issues of this file since that's just a copied HTML placeholder and contains issues.

// @codingStandardsIgnoreFile
get_header();
?>
<div class="travel-overlay-fx-scale">
    <div class="travel-no-focus flex-auto overflow-auto" role="button" tabindex="-1" on="tap:AMP.setState({ui_filterPane: false, ui_reset: false, ui_sortPane: false})">

        <!-- Results -->
        <section class="travel-results pb1 md-pt1">
            <div class="travel-inline-list travel-results-list">
                <div class="max-width-3 mx-auto px1 md-px2">
                    <?php if ( have_posts() ): while ( have_posts() ) : ?>
                        <?php the_post(); ?>
                        <div class="col-12 sm-col-6 lg-col-4 p1 travel-results-result" style="float:left;">
                            <div class="relative travel-results-result">
                                <a class="travel-results-result-link" href="<?php the_permalink(); ?>">
                                    <amp-img class="rounded bg-silver mb1" width="2" height="1" noloading="" layout="responsive" src="<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>" ></amp-img>
                                </a>
                            </div>
                            <div class="h2 line-height-2 mb1">
                                <span class="travel-results-result-text"><?php echo get_the_title(); ?></span>
                                <span class="travel-results-result-subtext h3">&bull;</span>
                                <span class="travel-results-result-subtext h3">$&nbsp;</span>
                                <span class="bold">100</span>
                            </div>
                            <div class="h4 line-height-2">
                                <div class="inline-block relative mr1 h3 line-height-2">

                                </div>
                                <span class="travel-results-result-subtext mr1">Not Yet Reviewed</span>
                                <span class="nowrap">
                                        --
                                    </span>
                            </div>
                        </div>
                    <?php
                    endwhile;
                    else: ?>
                    <div>No results</div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <!--/ Results -->
    </div>
</div>
