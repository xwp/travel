/* globals travelGlobals */
/* jscs:disable validateQuoteMarks */

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
	'amp-travel/featured',
	{
		title: __( 'Featured Destinations' ),
		category: 'common',
		icon: 'location-alt',
		keywords: [
			__( 'Featured destinations' ),
			__( 'Adventures' ),
			__( 'Travel' )
		],

		edit: withAPIData( () => {
			return {
				featuredLocations: '/wp/v2/locations?per_page=6&meta_value=1&meta_key=amp_travel_featured'
			};
		} )( ( { featuredLocations, isSelected, setAttributes, attributes: { heading } } ) => { // eslint-disable-line
			const hasLocations = Array.isArray( featuredLocations.data ) && 6 <= featuredLocations.data.length;
			if ( ! hasLocations ) {
				return (
					<Placeholder key='placeholder'
								icon='admin-post'
								label={ __( 'Locations' ) }
					>
						{ __( 'Not enough featured locations found. Please add at least six "Locations" terms, select an image, and check "Featured destination."' ) }
					</Placeholder>
				);
			}

			const locations = featuredLocations.data;
			const imgStyles = [
				{
					width: 336,
					height: 507
				},
				{
					width: 264,
					height: 246
				},
				{
					width: 264,
					height: 264
				},
				{
					width: 276,
					height: 207
				},
				{
					width: 264,
					height: 286
				},
				{
					width: 312,
					height: 507
				}
			];

			return [
				isSelected && (
					<InspectorControls key='inspector'>
						<PanelBody title={ __( 'Featured Destinations settings' ) }>
							<TextControl
								label={ __( 'Featured Destinations Header' ) }
								value={ heading }
								onChange={ ( value ) => setAttributes( { heading: value } ) } // eslint-disable-line
							/>
						</PanelBody>
					</InspectorControls>
				),
				<section className='travel-featured pt3 relative clearfix'>
					<header className='max-width-2 mx-auto px1 md-px2 relative'>
						<h3 className='travel-featured-heading h1 bold line-height-2 mb2 center'>{ heading }</h3>
					</header>
					<div className='max-width-3 mx-auto relative'>
						<div className='travel-featured-grid flex flex-wrap items-stretch'>
							<div className='col-12 md-col-6 flex items-stretch flex-auto'>
								<a href={ locations[0].link } className='travel-featured-tile flex flex-auto relative travel-featured-color-blue'>
									<img className='travel-object-cover flex-auto' layout='responsive' style={ imgStyles[0] }  width='336' height='507' src={ locations[0].meta.amp_travel_location_img }></img>
									<div className='travel-featured-overlay absolute z1 center top-0 right-0 bottom-0 left-0 white p2'>
										<div className='travel-featured-tile-heading caps bold line-height-2 h3'>{ locations[0].name }</div>
										<div className='h5'>{ locations[0].count + __( ' adventures' ) }</div>
									</div>
								</a>
								<div className='flex flex-column items-stretch flex-auto'>
									<a href={ locations[1].link } className='travel-featured-tile flex flex-auto relative travel-featured-color-cyan'>
										<img className='travel-object-cover flex-auto' layout='responsive' style={ imgStyles[1] } width='264' height='246' src={ locations[1].meta.amp_travel_location_img }></img>
										<div className='travel-featured-overlay absolute z1 center top-0 right-0 bottom-0 left-0 white p2'>
											<div className='travel-featured-tile-heading bold caps line-height-2 h3'>{ locations[1].name }</div>
											<div className='h5'>{ locations[1].count + __( ' adventures' ) }</div>
										</div>
									</a>
									<a href={ locations[2].link } className='travel-featured-tile flex flex-auto pointer relative travel-featured-color-orange'>
										<img className='travel-object-cover flex-auto' layout='responsive' style={ imgStyles[2] } width='264' height='264' src={ locations[2].meta.amp_travel_location_img }></img>
										<div className='travel-featured-overlay absolute z1 center top-0 right-0 bottom-0 left-0 white p2'>
											<div className='travel-featured-tile-heading bold caps line-height-2 h3'>{ locations[2].name }</div>
											<div className='h5'>{ locations[2].count + __( ' adventures' ) }</div>
										</div>
									</a>
								</div>
							</div>
							<div className='col-12 md-col-6 flex items-stretch flex-auto'>
								<div className='flex flex-column items-stretch flex-auto'>
									<a href={ locations[3].link } className='travel-featured-tile flex flex-auto pointer relative travel-featured-color-purple'>
										<img className='travel-object-cover flex-auto' layout='responsive' style={ imgStyles[3] } width='276' height='207' src={ locations[3].meta.amp_travel_location_img }></img>
										<div className='travel-featured-overlay absolute z1 center top-0 right-0 bottom-0 left-0 white p2'>
											<div className='travel-featured-tile-heading caps bold line-height-2 h3'>{ locations[3].name }</div>
											<div className='h5'>{ locations[3].count + __( ' adventures' ) }</div>
										</div>
									</a>
									<a href={ locations[4].link } className='travel-featured-tile flex flex-auto relative travel-featured-color-cornflower'>
										<img className='travel-object-cover flex-auto' layout='responsive' style={ imgStyles[4] } width='264' height='286' src={ locations[4].meta.amp_travel_location_img }></img>
										<div className='travel-featured-overlay absolute z1 center top-0 right-0 bottom-0 left-0 white p2'>
											<div className='travel-featured-tile-heading caps bold line-height-2 h3'>{ locations[4].name }</div>
											<div className='h5'>{ locations[4].count + __( ' adventures' ) }</div>
										</div>
									</a>
								</div>
								<a href={ locations[5].link } className='travel-featured-tile flex flex-auto relative travel-featured-color-teal'>
									<img className='travel-object-cover flex-auto' layout='responsive' style={ imgStyles[5] } width='312' height='507' src={ locations[5].meta.amp_travel_location_img }></img>
									<div className='travel-featured-overlay absolute z1 center top-0 right-0 bottom-0 left-0 white p2'>
										<div className='travel-featured-tile-heading caps bold h3'>{ locations[5].name }</div>
										<div className='h5'>{ locations[5].count + __( ' adventures' ) }</div>
									</div>
								</a>
							</div>
						</div>
					</div>
				</section>
			];
		} ), // eslint-disable-line
		save() {

			// Render in PHP.
			return null;
		}
	}
);
