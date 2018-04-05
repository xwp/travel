/* globals travelGlobals */

/**
 * Internal block libraries.
 */
const { __ } = wp.i18n;
const { registerBlockType, RichText } = wp.blocks;
const { Placeholder, withAPIData } = wp.components;

/**
 * Register block.
 */
export default registerBlockType(
	'amp-travel/popular',
	{
		title: __( 'Popular Adventures' ),
		category: 'common',
		icon: 'wordpress-alt',
		keywords: [
			__( 'Top rated' ),
			__( 'Best' ),
			__( 'Travel' )
		],

		attributes: {
			heading: {
				source: 'children',
				type: 'array',
				selector: '.travel-popular h3'
			}
		},

		edit: withAPIData( () => {
			return {
				popularPosts: '/wp/v2/posts?per_page=3&orderby=meta_value_num&meta_key=amp_travel_rating&_embed=true'
			};
		} )( ( { popularPosts, attributes, setAttributes } ) => { // eslint-disable-line
			const hasAdventures = Array.isArray( popularPosts.data ) && popularPosts.data.length;
			if ( ! hasAdventures ) {
				return (
					<Placeholder key='placeholder' icon='admin-post' label={ __( 'Adventures' ) } >
						{ __( 'No popular adventures found, add some to use the block.' ) }
					</Placeholder>
				);
			}

			const adventures = popularPosts.data;
			const { heading } = attributes;
			return (
				<section className='travel-popular pb4 pt3 relative'>
					<header className='max-width-3 mx-auto px1 md-px2'>
						<RichText
							key='editable'
							className='h1 bold line-height-2'
							tagName='h3'
							value={ heading }
							onChange={ ( value ) => setAttributes( { heading: value } ) } // eslint-disable-line
							placeholder={ __( 'Top Adventures' ) }
						/>
					</header>
					<div className='overflow-scroll'>
						<div className='travel-overflow-container'>
							<div className='flex px1 md-px2 mxn1'>
								{ adventures.map( ( adventure, i ) => // eslint-disable-line
									<div key='adventure' className='m1 mt3 mb2'>
										<div className='travel-popular-tilt-right mb1'>
											<div className='relative travel-results-result'>
												<a className='travel-results-result-link block relative' href={ adventure.link }>
													<img className='block rounded' width='346' height='200' ></img>
												</a>
												<div className='travel-results-result-like absolute top-0 right-0'>
													<div className='p1'>
														<label className='travel-like'>
															<input type='checkbox' className='absolute'/>
															<div className='travel-like-hearts circle inline-block relative'>
																<div className='travel-like-heart-tiny travel-like-heart-solid absolute'></div>
																<div className='travel-like-heart-tiny travel-like-heart-solid absolute'></div>
																<div className='travel-like-heart-tiny travel-like-heart-solid absolute'></div>
																<div className='travel-like-heart travel-like-heart-white absolute mx-auto '></div>
																<div className='travel-like-heart travel-like-heart-solid absolute mx-auto '></div>
																<div className='travel-like-heart travel-like-heart-outline absolute mx-auto '></div>
															</div>
														</label>
													</div>
												</div>
											</div>
										</div>

										<div className='h2 line-height-2 mb1'>
											<span className='travel-results-result-text'>{ adventure.title.rendered }</span>
											<span className='travel-results-result-subtext h3'>•</span>
											<span className='travel-results-result-subtext h3'>$&nbsp;</span><span className='black bold'>{ adventure.meta.amp_travel_price }</span>
										</div>

										<div className='h4 line-height-2'>
											<div className='inline-block relative mr1 h3 line-height-2'>
												<div className='travel-results-result-stars green'>★★★★★</div>
											</div>
											<span className='travel-results-result-subtext mr1'>{ adventure.meta.amp_travel_review_count } Reviews</span>
											<span className='travel-results-result-subtext'><svg className='travel-icon' viewBox='0 0 77 100'><g fill='none' fillRule='evenodd'><path stroke='currentColor' strokeWidth='7.5' d='M38.794 93.248C58.264 67.825 68 49.692 68 38.848 68 22.365 54.57 9 38 9S8 22.364 8 38.85c0 10.842 9.735 28.975 29.206 54.398a1 1 0 0 0 1.588 0z'></path><circle cx='38' cy='39' r='10' fill='currentColor'></circle></g></svg>{ adventure['wp:term'][0].name }</span>
										</div>
									</div>
								) }
							</div>
						</div>
					</div>
				</section>
			);
		}),
		save() {

			// Handled by PHP.
			return null;
		}
	}
);
