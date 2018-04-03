/* globals travelGlobals */
/* jscs:disable disallowMultipleLineStrings */
/* jscs:disable validateQuoteMarks */

/**
 * Internal block libraries.
 */
const { __ } = wp.i18n;
const { registerBlockType, RichText } = wp.blocks;

/**
 * Register block.
 */
export default registerBlockType(
	'amp-travel/search',
	{
		title: __( 'Search' ),
		category: 'common',
		icon: 'wordpress-alt',
		keywords: [
			__( 'Adventure' ),
			__( 'Travel' )
		],

		attributes: {
			heading: {
				source: 'children',
				type: 'array',
				selector: '.travel-search-heading'
			},
			ctaText: {
				source: 'children',
				type: 'array',
				selector: '.travel-search .travel-link',
				default: [ __( 'Find my next adventure' ) ]
			}
		},

		edit( { attributes, setAttributes } ) {
			const { heading, ctaText } = attributes;
			return (
				<section className='travel-search py4 xs-hide sm-hide relative'>
					<div className='px1 md-px2 pb1 relative'>
						<RichText
							key='editable'
							className='travel-search-heading travel-spacing-none h2 bold mb2 center'
							tagName='h3'
							value={ heading }
							onChange={ ( value ) => setAttributes( { heading: value } ) }
							placeholder={ __( 'Have a specific destination in mind?' ) }
						/>
						<div className='flex justify-center pb2'>
							<div className='travel-input-group flex col-12 items-center'>
								<span className='travel-input travel-input-big line-height-2 block col-12 flex-auto rounded-left'>{ __( 'Where would you like to go?' ) }</span>
								<span className='travel-input-group-sep travel-border-gray relative z1 block'></span>
								<RichText
									className='travel-link travel-input travel-input-big line-height-2 link rounded-right nowrap text-decoration-none'
									key='editable'
									tagName='a'
									value={ ctaText || [ __( 'Find my next adventure' ) ] }
									onChange={ ( value ) => setAttributes( { ctaText: value } ) }
								/>
						</div>
					</div>
				</div>
			</section>
			);
		},
		save( { attributes } ) {
			const ampValueProp = {
				'[value]': 'fields_query'
			};
			const ampHrefProp = {
				'[href]': "'" + travelGlobals.siteUrl + "?category_name=' + fields_query"
			};
			return (
				<section className='travel-search py4 xs-hide sm-hide relative'>
					<div className='px1 md-px2 pb1 relative'>
						<h3 className='travel-search-heading travel-spacing-none h1 bold mb2 center'>{ attributes.heading }</h3>

						<div className='flex justify-center pb2'>
							<div className='travel-input-group flex items-center col-8'>
								<input className='travel-input travel-input-big line-height-2 block col-12 flex-auto rounded-left' type='text' name='query' placeholder='Where would you like to go?' on='change:AMP.setState({fields_query: event.value})' value='' { ...ampValueProp } />
								<span className='travel-input-group-sep travel-border-gray relative z1 block'></span>
								<a href={ travelGlobals.siteUrl + '?category_name=' } { ...ampHrefProp } className='travel-link travel-input travel-input-big line-height-2 link rounded-right nowrap text-decoration-none' on='
								tap:AMP.setState({
								ui_reset: false,
								ui_filterPane: false,
								query_query: fields_query,
								fields_query_edited: false,
								query_departure: fields_departure,
								fields_departure_edited: false,
								query_return: fields_return,
								fields_return_edited: false,
								query_maxPrice: fields_maxPrice,
								fields_maxPrice_edited: false,
								query_city: fields_city,
								fields_city_edited: false,
								query_type: fields_type,
								fields_type_edited: false,
								query_sort: fields_sort,
								fields_sort_edited: false,
							})
								'>
									{ attributes.ctaText }
								</a>
							</div>
						</div>
					</div>
				</section>
			);
		}
	},
);
