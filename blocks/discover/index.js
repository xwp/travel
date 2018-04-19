/* eslint-disable space-in-parens */

/**
 * Internal block libraries.
 */
const { __ } = wp.i18n;
const { registerBlockType, RichText } = wp.blocks;
const { withAPIData } = wp.components;
const { RawHTML } = wp.element;
const { decodeEntities }  = wp.utils;

/**
 * Register block.
 */
export default registerBlockType(
	'amp-travel/discover',
	{
		title: __( 'Discover block' ),
		category: 'common',
		icon: 'palmtree',
		keywords: [
			__( 'Adventures' ),
			__( 'Travel' )
		],

		edit: withAPIData( () => {
			return {
				posts: '/wp/v2/posts?per_page=1'
			};
		} )( ( { posts } ) => {
			if ( ! posts.data ) {
				return __( 'Loading...' );
			}

			const content = 0 === posts.data.length ?
				(
					<div className='travel-discover-panel travel-shadow-hover px3 py2 ml1 mr3 myn3'>
						<div>{ __( 'No posts found, add some to use the block.' ) }</div>
					</div> ) :
				(
					<div className='travel-discover-panel travel-shadow-hover px3 py2 ml1 myn3'>
						<div className='bold h2 line-height-2 my1'>{ posts.data[0].title.rendered }</div>
						<p className='travel-discover-panel-subheading h3 my1 line-height-2'>
							<RawHTML key='html'>{ decodeEntities( posts.data[0].excerpt.rendered ) }</RawHTML>
						</p>
						<p className='my1'>
							<a className='travel-link' href={ posts.data[0].link }>{ __( 'Read more' ) }</a>
						</p>
					</div>
				);

			return (
				<section className='travel-discover py4 mb3 relative'>
					<div className='max-width-3 mx-auto'>
						<div className='flex justify-between items-center'>
							<header>
								<h2 className='travel-discover-heading bold line-height-2 xs-hide sm-hide'>{ __( 'Discover Adventures' ) }</h2>
								<div className='travel-discover-subheading h2 xs-hide sm-hide'>{ __( 'Get inspired and find your next big trip' ) }</div>
							</header>
							{ content }
						</div>
					</div>
				</section>
			);
		} ),
		save() {

			// Render in PHP.
			return null;
		}
	}
);
