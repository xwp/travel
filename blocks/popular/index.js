/* globals travelGlobals */

/**
 * Internal block libraries.
 */
const { __ } = wp.i18n;
const { registerBlockType, InspectorControls } = wp.blocks;
const { Placeholder, withAPIData, TextControl, PanelBody } = wp.components;

/**
 * Register block.
 */
export default registerBlockType(
	'amp-travel/popular',
	{
		title: __( 'Popular Adventures' ),
		category: 'common',
		icon: 'universal-access',
		keywords: [
			__( 'Top rated' ),
			__( 'Best' ),
			__( 'Travel' )
		],

		edit: withAPIData( () => {
			return {
				popularPosts: '/wp/v2/adventures?per_page=3&orderby=meta_value_num&meta_key=amp_travel_rating&_embed'
			};
		} )( ( { popularPosts, isSelected, setAttributes, attributes: { heading } } ) => { // eslint-disable-line
			const popularPostsCount = 3;
			const hasAdventures = Array.isArray( popularPosts.data ) && popularPosts.data.length;
			if ( ! hasAdventures || popularPostsCount !== popularPosts.data.length ) {
				return (
					<Placeholder key='placeholder' icon='admin-post' label={ __( 'Adventures' ) } >
						{ __( 'Not enough adventures with ratings found, add at least 3 to use the block.' ) }
					</Placeholder>
				);
			}

			const adventures = popularPosts.data;
			const popularClasses = [
				'travel-popular-tilt-right',
				'travel-results-result',
				'travel-popular-tilt-left'
			];

			return [
				isSelected && (
					<InspectorControls key='inspector'>
						<PanelBody title={ __( 'Popular block settings' ) }>
							<TextControl
								label={ __( 'Popular Adventures Header' ) }
								value={ heading }
								onChange={ ( value ) => setAttributes( { heading: value } ) } // eslint-disable-line
							/>
						</PanelBody>
					</InspectorControls>
				),
				<section key='popular' className='travel-popular pb4 pt3 relative'>
					<header className='max-width-3 mx-auto px1 md-px2'>
						<h3 className='h1 bold line-height-2'>{ heading }</h3>
					</header>
					<div className='overflow-scroll'>
						<div className='travel-overflow-container'>
							<div className='flex px1 md-px2 mxn1'>
								{ adventures.map( ( adventure, i ) => // eslint-disable-line
									<div key='adventure' className='m1 mt3 mb2'>
										<div className={ popularClasses[ i ] + ' mb1' }>
											<div className='relative travel-results-result'>
												<a className='travel-results-result-link block relative' href={ adventure.link }>
													<img src={ adventure._embedded['wp:featuredmedia'][0].source_url } className='block rounded' width='346' height='200' ></img>
												</a>
											</div>
										</div>

										<div className='h2 line-height-2 mb1'>
											<span className='travel-results-result-text'>{ adventure.title.rendered }</span>
											<span className='travel-results-result-subtext h3'>•</span>
											<span className='travel-results-result-subtext h3'>$&nbsp;</span><span className='black bold'>{ adventure.meta.amp_travel_price }</span>
										</div>

										<div className='h4 line-height-2'>
											<div className='inline-block relative mr1 h3 line-height-2'>
												<div className='travel-results-result-stars green'>
													{ [ ...Array( parseInt( adventure.meta.amp_travel_rating ) ) ].map( () =>
														'★'
													) }
												</div>
											</div>
											<span className='travel-results-result-subtext mr1'>{ adventure.meta.amp_travel_reviews } Reviews</span>
											<span className='travel-results-result-subtext'><svg className='travel-icon' viewBox='0 0 77 100'><g fill='none' fillRule='evenodd'><path stroke='currentColor' strokeWidth='7.5' d='M38.794 93.248C58.264 67.825 68 49.692 68 38.848 68 22.365 54.57 9 38 9S8 22.364 8 38.85c0 10.842 9.735 28.975 29.206 54.398a1 1 0 0 0 1.588 0z'></path><circle cx='38' cy='39' r='10' fill='currentColor'></circle></g></svg>
												{ adventure.meta.amp_travel_location }
												</span>
										</div>
									</div>
								) }
							</div>
						</div>
					</div>
				</section>
			];
		}),
		save() {

			// Handled by PHP.
			return null;
		}
	}
);
