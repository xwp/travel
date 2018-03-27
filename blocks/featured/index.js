/**
 * Internal block libraries.
 */
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

/**
 * Register block.
 */
export default registerBlockType(
	'amp-travel/featured',
	{
		title: __( 'Featured' ),
		category: 'common',
		icon: 'wordpress-alt',
		keywords: [
			__( 'Featured destinations' ),
			__( 'Adventures' ),
			__( 'Travel' ),
		],

		// Copied from Travel template HTML, removed amp tags not to break edit.
		edit: props => {
			return (
				<section className="travel-featured pt3 relative clearfix">
					<header className="max-width-2 mx-auto px1 md-px2 relative">
						<h3 className="travel-featured-heading h1 bold line-height-2 mb2 center">Featured Destinations</h3>
					</header>
					<div className="max-width-3 mx-auto relative">
						<div className="travel-featured-grid flex flex-wrap items-stretch">
							<div className="col-12 md-col-6 flex items-stretch flex-auto">
								<a href="travel-results.amp" className="travel-featured-tile flex flex-auto relative travel-featured-color-blue">
									<img width="336" height="507" decoding="async" className="i-amphtml-fill-content i-amphtml-replaced-content" src="/wp-content/themes/travel/img/new-york.jpg" />
									<div className="travel-featured-overlay absolute z1 center top-0 right-0 bottom-0 left-0 white p2">
										<div className="travel-featured-tile-heading caps bold line-height-2 h3">New York</div>
										<div className="h5">379 adventures</div>
									</div>
								</a>
								<div className="flex flex-column items-stretch flex-auto">
									<a href="travel-results.amp" className="travel-featured-tile flex flex-auto relative travel-featured-color-cyan">
										<img width="264" height="246" decoding="async" className="i-amphtml-fill-content i-amphtml-replaced-content" src="/wp-content/themes/travel/img/barcelona.jpg" />
										<div className="travel-featured-overlay absolute z1 center top-0 right-0 bottom-0 left-0 white p2">
											<div className="travel-featured-tile-heading bold caps line-height-2 h3">Barcelona</div>
											<div className="h5">68 adventures</div>
										</div>
									</a>
									<a href="travel-results.amp" className="travel-featured-tile flex flex-auto pointer relative travel-featured-color-orange">
										<img width="264" height="264" decoding="async" className="i-amphtml-fill-content i-amphtml-replaced-content" src="/wp-content/themes/travel/img/paris.jpg" />
										<div className="travel-featured-overlay absolute z1 center top-0 right-0 bottom-0 left-0 white p2">
											<div className="travel-featured-tile-heading bold caps line-height-2 h3">Paris</div>
											<div className="h5">221 adventures</div>
										</div>
									</a>
								</div>
							</div>
							<div className="col-12 md-col-6 flex items-stretch flex-auto">
								<div className="flex flex-column items-stretch flex-auto">
									<a href="travel-results.amp" className="travel-featured-tile flex flex-auto pointer relative travel-featured-color-purple">
										<img width="276" height="207" decoding="async" className="i-amphtml-fill-content i-amphtml-replaced-content" src="/wp-content/themes/travel/img/tokyo.jpg" />
										<div className="travel-featured-overlay absolute z1 center top-0 right-0 bottom-0 left-0 white p2">
											<div className="travel-featured-tile-heading caps bold line-height-2 h3">Tokyo</div>
											<div className="h5">500+ adventures</div>
										</div>
									</a>
									<a href="travel-results.amp" className="travel-featured-tile flex flex-auto relative travel-featured-color-cornflower">
										<img width="264" height="286" decoding="async" className="i-amphtml-fill-content i-amphtml-replaced-content" src="/wp-content/themes/travel/img/chicago.jpg" />
										<div className="travel-featured-overlay absolute z1 center top-0 right-0 bottom-0 left-0 white p2">
											<div className="travel-featured-tile-heading caps bold line-height-2 h3">Chicago</div>
											<div className="h5">143 adventures</div>
										</div>
									</a>
								</div>
								<a href="travel-results.amp" className="travel-featured-tile flex flex-auto relative travel-featured-color-teal">
									<img width="312" height="507" decoding="async" className="i-amphtml-fill-content i-amphtml-replaced-content" src="/wp-content/themes/travel/img/reykjavik.jpg" />
									<div className="travel-featured-overlay absolute z1 center top-0 right-0 bottom-0 left-0 white p2">
										<div className="travel-featured-tile-heading caps bold h3">Reykjavik</div>
										<div className="h5">87 adventures</div>
									</div>
								</a>
							</div>
						</div>
					</div>
				</section>
			);
		},
		save: props => {
			return (
				<section className="travel-featured pt3 relative clearfix">
					<header className="max-width-2 mx-auto px1 md-px2 relative">
						<h3 className="travel-featured-heading h1 bold line-height-2 mb2 center">Featured Destinations</h3>
					</header>
					<div className="max-width-3 mx-auto relative">
						<div className="travel-featured-grid flex flex-wrap items-stretch">
							<div className="col-12 md-col-6 flex items-stretch flex-auto">
								<a href="travel-results.amp" className="travel-featured-tile flex flex-auto relative travel-featured-color-blue" on="tap:AMP.setState({fields_query: 'New York', query_query: 'New York'})">
									<amp-img className="travel-object-cover flex-auto i-amphtml-element i-amphtml-layout-responsive i-amphtml-layout-size-defined i-amphtml-layout" layout="responsive" width="336" height="507" src="/wp-content/themes/travel/img/new-york.jpg"><i-amphtml-sizer style="display: block; padding-top: 150.893%;"></i-amphtml-sizer><img decoding="async" className="i-amphtml-fill-content i-amphtml-replaced-content" src="/wp-content/themes/travel/img/new-york.jpg" /></amp-img>
									<div className="travel-featured-overlay absolute z1 center top-0 right-0 bottom-0 left-0 white p2">
										<div className="travel-featured-tile-heading caps bold line-height-2 h3">New York</div>
										<div className="h5">379 adventures</div>
									</div>
								</a>
								<div className="flex flex-column items-stretch flex-auto">
									<a href="travel-results.amp" className="travel-featured-tile flex flex-auto relative travel-featured-color-cyan" on="tap:AMP.setState({fields_query: 'Barcelona', query_query: 'Barcelona'})">
										<amp-img className="travel-object-cover flex-auto i-amphtml-element i-amphtml-layout-responsive i-amphtml-layout-size-defined i-amphtml-layout" layout="responsive" width="264" height="246" src="/wp-content/themes/travel/img/barcelona.jpg"><i-amphtml-sizer style="display: block; padding-top: 93.1818%;"></i-amphtml-sizer><img decoding="async" className="i-amphtml-fill-content i-amphtml-replaced-content" src="/wp-content/themes/travel/img/barcelona.jpg" /></amp-img>
										<div className="travel-featured-overlay absolute z1 center top-0 right-0 bottom-0 left-0 white p2">
											<div className="travel-featured-tile-heading bold caps line-height-2 h3">Barcelona</div>
											<div className="h5">68 adventures</div>
										</div>
									</a>
									<a href="travel-results.amp" className="travel-featured-tile flex flex-auto pointer relative travel-featured-color-orange" on="tap:AMP.setState({fields_query: 'Paris', query_query: 'Paris'})">
										<amp-img className="travel-object-cover flex-auto i-amphtml-element i-amphtml-layout-responsive i-amphtml-layout-size-defined i-amphtml-layout" layout="responsive" width="264" height="264" src="/wp-content/themes/travel/img/paris.jpg"><i-amphtml-sizer style="display: block; padding-top: 100%;"></i-amphtml-sizer><img decoding="async" className="i-amphtml-fill-content i-amphtml-replaced-content" src="/wp-content/themes/travel/img/paris.jpg" /></amp-img>
										<div className="travel-featured-overlay absolute z1 center top-0 right-0 bottom-0 left-0 white p2">
											<div className="travel-featured-tile-heading bold caps line-height-2 h3">Paris</div>
											<div className="h5">221 adventures</div>
										</div>
									</a>
								</div>
							</div>
							<div className="col-12 md-col-6 flex items-stretch flex-auto">
								<div className="flex flex-column items-stretch flex-auto">
									<a href="travel-results.amp" className="travel-featured-tile flex flex-auto pointer relative travel-featured-color-purple" on="tap:AMP.setState({fields_query: 'Tokyo', query_query: 'Tokyo'})">
										<amp-img className="travel-object-cover flex-auto i-amphtml-element i-amphtml-layout-responsive i-amphtml-layout-size-defined i-amphtml-layout" layout="responsive" width="276" height="207" src="/wp-content/themes/travel/img/tokyo.jpg"><i-amphtml-sizer style="display: block; padding-top: 75%;"></i-amphtml-sizer><img decoding="async" className="i-amphtml-fill-content i-amphtml-replaced-content" src="/wp-content/themes/travel/img/tokyo.jpg" /></amp-img>
										<div className="travel-featured-overlay absolute z1 center top-0 right-0 bottom-0 left-0 white p2">
											<div className="travel-featured-tile-heading caps bold line-height-2 h3">Tokyo</div>
											<div className="h5">500+ adventures</div>
										</div>
									</a>
									<a href="travel-results.amp" className="travel-featured-tile flex flex-auto relative travel-featured-color-cornflower" on="tap:AMP.setState({fields_query: 'Chicago', query_query: 'Chicago'})">
										<amp-img className="travel-object-cover flex-auto i-amphtml-element i-amphtml-layout-responsive i-amphtml-layout-size-defined i-amphtml-layout" layout="responsive" width="264" height="286" src="/wp-content/themes/travel/img/chicago.jpg"><i-amphtml-sizer style="display: block; padding-top: 108.333%;"></i-amphtml-sizer><img decoding="async" className="i-amphtml-fill-content i-amphtml-replaced-content" src="/wp-content/themes/travel/img/chicago.jpg" /></amp-img>
										<div className="travel-featured-overlay absolute z1 center top-0 right-0 bottom-0 left-0 white p2">
											<div className="travel-featured-tile-heading caps bold line-height-2 h3">Chicago</div>
											<div className="h5">143 adventures</div>
										</div>
									</a>
								</div>
								<a href="travel-results.amp" className="travel-featured-tile flex flex-auto relative travel-featured-color-teal" on="tap:AMP.setState({fields_query: 'Reykjavik', query_query: 'Reykjavik'})">
									<amp-img className="travel-object-cover flex-auto i-amphtml-element i-amphtml-layout-responsive i-amphtml-layout-size-defined i-amphtml-layout" layout="responsive" width="312" height="507" src="/wp-content/themes/travel/img/reykjavik.jpg"><i-amphtml-sizer style="display: block; padding-top: 162.5%;"></i-amphtml-sizer><img decoding="async" className="i-amphtml-fill-content i-amphtml-replaced-content" src="/wp-content/themes/travel/img/reykjavik.jpg" /></amp-img>
									<div className="travel-featured-overlay absolute z1 center top-0 right-0 bottom-0 left-0 white p2">
										<div className="travel-featured-tile-heading caps bold h3">Reykjavik</div>
										<div className="h5">87 adventures</div>
									</div>
								</a>
							</div>
						</div>
					</div>
				</section>
			);
		},
	},
);
