/* globals travelGlobals */
/* jscs:disable disallowMultipleLineStrings */
/* jscs:disable validateQuoteMarks */
/* eslint-disable quotes */
/* eslint-disable space-in-parens */

/**
 * Internal block libraries.
 */
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { RichText } = wp.editor;

/**
 * Register block.
 */
export default registerBlockType(
	'amp-travel/search',
	{
		title: __( 'Travel Search' ),
		category: 'common',
		icon: 'search',
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

		edit( { attributes, setAttributes } ) { // eslint-disable-line
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
							placeholder={ __( 'Have a specific adventure in mind?' ) }
						/>
						<div className='flex justify-center pb2'>
							<div className='travel-input-group flex col-12 items-center'>
								<span className='travel-input travel-input-big line-height-2 block col-12 flex-auto rounded-left'>{ __( 'Search for adventures' ) }</span>
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
		save( { attributes } ) { // eslint-disable-line
			const ampValueProp = {
				'[value]': 'search_query.search'
			};
			const ampHrefProp = {
				'[href]': "'" + travelGlobals.siteUrl + "?s=' + search_query.search"
			};
			return (
				<section className='travel-search py4 xs-hide sm-hide relative'>
					<div className='px1 md-px2 pb1 relative'>
						<h3 className='travel-search-heading travel-spacing-none h1 bold mb2 center'>{ attributes.heading }</h3>

						<div className='flex justify-center pb2'>
							<div className='travel-input-group flex items-center col-8'>
								<input className='travel-input travel-input-big line-height-2 block col-12 flex-auto rounded-left' type='text' name='query' placeholder='Search for adventures' on='input-throttled:AMP.setState({search_query: {search: event.value}})' value='' { ...ampValueProp } />
								<span className='travel-input-group-sep travel-border-gray relative z1 block'></span>
								<a href={ travelGlobals.siteUrl + '?s=' } { ...ampHrefProp } className='travel-link travel-input travel-input-big line-height-2 link rounded-right nowrap text-decoration-none'>
									{ attributes.ctaText }
								</a>
							</div>
						</div>
					</div>
				</section>
			);
		}
	}
);
