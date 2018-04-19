/* globals travelGlobals */
/* jscs:disable disallowMultipleLineStrings */
/* jscs:disable validateQuoteMarks */
/* eslint-disable space-in-parens */
/* eslint-disable quotes */

/**
 * Internal block libraries.
 */
const { __ } = wp.i18n;
const { registerBlockType, RichText } = wp.blocks;

/**
 * Register block.
 */
export default registerBlockType(
	'amp-travel/hero',
	{
		title: __( 'Hero block' ),
		description: __( 'Hero block of the Travel theme. Includes main heading, subheading, and search with datepicker.' ),
		category: 'common',
		icon: 'wordpress-alt',
		keywords: [
			__( 'Main header' ),
			__( 'Heading' ),
			__( 'Title' )
		],

		attributes: {
			heading: {
				source: 'children',
				type: 'array',
				selector: 'h1'
			},
			subheading: {
				source: 'children',
				type: 'array',
				selector: '.travel-hero-subheading'
			},
			ctaText: {
				source: 'children',
				type: 'array',
				selector: 'a.ampstart-btn'
			}
		},

		edit( { attributes, setAttributes } ) { /* eslint-disable-line */
			const { heading, subheading, ctaText } = attributes;

			return [
				<div className="travel-hero-bg absolute col-12">
					<img className="absolute" width="100%" height="80vmax" src="http://localhost:8888/wordpress/wp-content/themes/travel/img/hero-1.jpg"/>
				</div>,
				<section className='travel-hero relative'>
					<div className='travel-hero-content-inner relative px1 md-px2 flex-auto self-end'>
						<header>
							<RichText
								key='editable'
								className='travel-hero-heading mb2 line-height-1'
								tagName='h1'
								value={ heading }
								onChange={ ( value ) => setAttributes( { heading: value } ) }
								placeholder={ __( 'Adventures made easy' ) }
							/>
							<RichText
								key='editable'
								className='travel-hero-subheading line-height-2 bold xs-hide sm-hide'
								tagName='h2'
								value={ subheading }
								onChange={ ( value ) => setAttributes( { subheading: value } ) }
								placeholder={ __( 'Find and book activities, tours, and experiences.' ) }
							/>
						</header>
						<div className='travel-hero-search'>
							<label className='travel-input-icon travel-shadow flex col-12 relative rounded'>
								<span className='travel-input travel-input-big travel-input-clear border block col-12 rounded' list='locations' name='query'>Search for adventures</span>
								<svg className='travel-icon' viewBox='0 0 74 100'><path fill='currentColor' d='M40.18 95.404A3.944 3.944 0 0 1 37 97a3.944 3.944 0 0 1-3.18-1.596C28.268 87.787 5 54.66 5 34.334 5 17.027 19.327 3 37 3c17.673 0 32 14.028 32 31.333 0 20.327-23.267 53.454-28.82 61.07zM37 14.75c-11.046 0-20 8.768-20 19.583 0 10.816 8.954 19.584 20 19.584s20-8.768 20-19.584c0-5.193-2.107-10.174-5.858-13.847-3.75-3.672-8.838-5.736-14.142-5.736z'></path></svg>
							</label>
							<div className='travel-hero-search-dates flex my2 justify-around'>
								<label className='travel-date-input relative bold flex-auto'  >
									<input className='block relative p0 z1' type='date' placeholder='yyyy-mm-dd' pattern='[0-9]{4}-[0-9]{2}-[0-9]{2}' title='yyyy-mm-dd' name='departure' />
									<svg className='travel-icon' viewBox='0 0 100 100'><path fill='currentColor' d='M7.93 79.476h84.32v8.876H7.93v-8.876zm86.848-41.538c-.932-3.55-4.615-5.68-8.165-4.704l-23.566 6.302L32.427 11l-8.566 2.263 18.374 31.82-22.056 5.902-8.743-6.834L5 45.883l8.077 14.023 3.417 5.903 7.1-1.91 23.566-6.3 19.305-5.148 23.565-6.302c3.594-1.02 5.68-4.66 4.748-8.21z'></path></svg>
									<div className='travel-date-input-label'>
										{ __( 'Start date' ) }
									</div>
								</label>
								<label className='travel-date-input relative bold flex-auto' >
									<input className='block relative p0 z1' type='date' placeholder='yyyy-mm-dd' pattern='[0-9]{4}-[0-9]{2}-[0-9]{2}' title='yyyy-mm-dd' name='return' />
									<svg className='travel-icon' viewBox='0 0 100 100'><path fill='currentColor' d='M7.929 79.476h84.32v8.876H7.929v-8.876zm81.693-15.409c1.03-3.523-1.03-7.246-4.576-8.238L61.6 49.094 50.051 8.863l-8.508-2.471-.64 36.737-21.946-6.3-3.974-10.361-6.407-1.831-.3 16.18-.11 6.82 7.069 2.021 23.445 6.735 19.199 5.53 23.445 6.736c3.607.976 7.269-1.069 8.298-4.592z'></path></svg>
									<div className='travel-date-input-label'>
										{ __( 'End date' ) }
									</div>
								</label>
							</div>

							<RichText
								className='ampstart-btn travel-input-big rounded center bold white block col-12'
								key='editable'
								tagName='a'
								value={ ctaText || [ __( 'Find Adventures & Tours' ) ] }
								onChange={ ( value ) => setAttributes( { ctaText: value } ) }
							/>
							<a className='travel-hero-discover block center mx-auto mt1 md-hide lg-hide'>
								Explore <svg className='travel-icon' viewBox='0 0 66 100'><path fill='currentColor' d='M33.5 56.172l-18.96-18.1c-1.497-1.43-3.922-1.43-5.418 0a3.539 3.539 0 0 0 0 5.17l21.67 20.687a3.914 3.914 0 0 0 2.708 1.07c.98 0 1.96-.357 2.71-1.07l21.668-20.687a3.541 3.541 0 0 0 0-5.172c-1.496-1.427-3.92-1.427-5.417 0L33.5 56.173z'></path></svg>
							</a>
						</div>
					</div>
				</section>,
				<div className='travel-angles max-width-3 mx-auto'>
					<div className='travel-angle-left'>
						<div className='travel-angle-1 absolute'></div>
					</div>
					<div className='travel-angle-left'>
						<div className='travel-angle-2 absolute'></div>
					</div>
					<div className='travel-angle-right'>
						<div className='travel-angle-3 absolute'></div>
					</div>
				</div>
			];
		},
		save( { attributes } ) { /* eslint-disable-line */

			const ampValueProp = {
				'[value]': 'fields_query'
			};

			const ampSrcProp = {
				'data-ampsrc': "'" + travelGlobals.apiUrl + "wp/v2/adventures?search=' + fields_query_live"
			};

			const departureClassNameProp = {
				'[class]': "'travel-date-input relative bold flex-auto' + (fields_start ? ' travel-date-input-touched' : '')"
			};
			const returnClassNameProp = {
				'[class]': "'travel-date-input relative bold flex-auto' + (fields_end ? ' travel-date-input-touched' : '')"
			};
			const ampHrefProp = {
				'[href]': "'" + travelGlobals.siteUrl + "?s=' + fields_query_live + '&start=' + (fields_start || '') + '&end=' + (fields_end || '')"
			};

			return (
				<div className="hero-wrapper">
					<section className='travel-hero relative'>
						<div className='travel-hero-content max-width-3 mx-auto absolute top-0 left-0 right-0 flex self-end items-center'>
							<div className='travel-hero-content-inner relative px1 md-px2 flex-auto self-end'>
								<header>
									<h1 className='travel-hero-heading mb2 line-height-1'>{ attributes.heading }</h1>
									<h2 className='travel-hero-subheading line-height-2 bold xs-hide sm-hide'>{ attributes.subheading }</h2>
								</header>
								<div className='travel-hero-search'>
									<label className='travel-input-icon travel-shadow flex col-12 relative rounded'>
										<input className='travel-input travel-input-big travel-input-clear border block col-12 rounded' list='locations' type='text' name='query' placeholder='Search for adventures' on='
										input-throttled:AMP.setState({
											fields_query: event.value,
											fields_query_live: event.value,
											fields_query_edited: query_query != event.value
										});
										input-debounced:AMP.setState({
											fields_query_live: event.value
										});' value='' { ...ampValueProp } />
										<svg className='travel-icon' viewBox='0 0 74 100'><path fill='currentColor' d='M40.18 95.404A3.944 3.944 0 0 1 37 97a3.944 3.944 0 0 1-3.18-1.596C28.268 87.787 5 54.66 5 34.334 5 17.027 19.327 3 37 3c17.673 0 32 14.028 32 31.333 0 20.327-23.267 53.454-28.82 61.07zM37 14.75c-11.046 0-20 8.768-20 19.583 0 10.816 8.954 19.584 20 19.584s20-8.768 20-19.584c0-5.193-2.107-10.174-5.858-13.847-3.75-3.672-8.838-5.736-14.142-5.736z'></path></svg>
									</label>

									<amp-list layout='fixed-height' height="1px" src={ travelGlobals.apiUrl + 'wp/v2/adventures' } {...ampSrcProp } aria-live='polite'>
										<template type='amp-mustache'>
											{ wp.element.createElement(
												'datalist',
												{
													id: 'locations'
												},
												'{{#adventures}}',
												wp.element.createElement(
													'option',
													{
														value: '{{title.rendered}}'
													},
													'{{/adventures}}'
												)
											) }
										</template>
									</amp-list>

								<div className='travel-hero-search-dates flex my2 justify-around'>
									<label className='travel-date-input relative bold flex-auto' { ...departureClassNameProp } >
										<input className='block relative p0 z1' type='date' placeholder='yyyy-mm-dd' pattern='[0-9]{4}-[0-9]{2}-[0-9]{2}' title='yyyy-mm-dd' name='departure' on='
											change:AMP.setState({
												fields_start: event.value
											})' />
										<svg className='travel-icon' viewBox='0 0 100 100'><path fill='currentColor' d='M7.93 79.476h84.32v8.876H7.93v-8.876zm86.848-41.538c-.932-3.55-4.615-5.68-8.165-4.704l-23.566 6.302L32.427 11l-8.566 2.263 18.374 31.82-22.056 5.902-8.743-6.834L5 45.883l8.077 14.023 3.417 5.903 7.1-1.91 23.566-6.3 19.305-5.148 23.565-6.302c3.594-1.02 5.68-4.66 4.748-8.21z'></path></svg>
										<div className='travel-date-input-label'>
											{ __( 'Start date' ) }
										</div>
									</label>
									<label className='travel-date-input relative bold flex-auto' { ...returnClassNameProp } >
										<input className='block relative p0 z1' type='date' placeholder='yyyy-mm-dd' pattern='[0-9]{4}-[0-9]{2}-[0-9]{2}' title='yyyy-mm-dd' name='return' on='
										change:AMP.setState({
											fields_end: event.value
										})' />
										<svg className='travel-icon' viewBox='0 0 100 100'><path fill='currentColor' d='M7.929 79.476h84.32v8.876H7.929v-8.876zm81.693-15.409c1.03-3.523-1.03-7.246-4.576-8.238L61.6 49.094 50.051 8.863l-8.508-2.471-.64 36.737-21.946-6.3-3.974-10.361-6.407-1.831-.3 16.18-.11 6.82 7.069 2.021 23.445 6.735 19.199 5.53 23.445 6.736c3.607.976 7.269-1.069 8.298-4.592z'></path></svg>
										<div className='travel-date-input-label'>
											{ __( 'End date' ) }
										</div>
									</label>
								</div>
								<a href={ travelGlobals.siteUrl + '?s=' } { ...ampHrefProp } className='ampstart-btn travel-input-big rounded center bold white block col-12'>
									{ attributes.ctaText }
								</a>
								<a className='travel-hero-discover block center mx-auto mt1 md-hide lg-hide' on='tap:travel-discover.scrollTo'>
									Explore <svg className='travel-icon' viewBox='0 0 66 100'><path fill='currentColor' d='M33.5 56.172l-18.96-18.1c-1.497-1.43-3.922-1.43-5.418 0a3.539 3.539 0 0 0 0 5.17l21.67 20.687a3.914 3.914 0 0 0 2.708 1.07c.98 0 1.96-.357 2.71-1.07l21.668-20.687a3.541 3.541 0 0 0 0-5.172c-1.496-1.427-3.92-1.427-5.417 0L33.5 56.173z'></path></svg>
								</a>
								</div>
							</div>
						</div>
					</section>
					<div className='travel-angles max-width-3 mx-auto'>
						<div className='travel-angle-left'>
							<div className='travel-angle-1 absolute'></div>
						</div>
						<div className='travel-angle-left'>
							<div className='travel-angle-2 absolute'></div>
						</div>
						<div className='travel-angle-right'>
							<div className='travel-angle-3 absolute'></div>
						</div>
					</div>,
				</div>
			);
		}
	}
);
