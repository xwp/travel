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
		icon: 'wordpress-alt',
		keywords: [
			__( 'Adventures' ),
			__( 'Travel' )
		],

		attributes: {
			heading: {
				source: 'children',
				type: 'array',
				selector: 'h2.travel-discover-heading'
			},
			subheading: {
				source: 'children',
				type: 'array',
				selector: '.travel-discover-subheading'
			}
		},

		edit: withAPIData( () => {
			return {
				posts: '/wp/v2/posts?per_page=1'
			};
		} )( ( { posts, attributes, setAttributes } ) => {
			const { heading, subheading } = attributes;

			if ( ! posts.data ) {
				return __( 'Loading' );
			}

			if ( 0 === posts.data.length ) {
				return (
					<section className='travel-discover py4 mb3 relative xs-hide sm-hide'>
						<div className='max-width-3 mx-auto'>
							<div className='flex justify-between items-center'>
								<header>
									<RichText
										key='editable'
										className='travel-discover-heading bold line-height-2 xs-hide sm-hide'
										tagName='h2'
										value={ heading }
										onChange={ ( value ) => setAttributes( { heading: value } ) }
										placeholder={ __( 'Discover Adventures' ) }
									/>
									<RichText
										key='editable'
										className='travel-discover-subheading h2 xs-hide sm-hide'
										tagName='div'
										value={ subheading }
										onChange={ ( value ) => setAttributes( { subheading: value } ) }
										placeholder={ __( 'Get inspired and find your next big trip' ) }
									/>
								</header>

								<div className='travel-discover-panel travel-shadow-hover px3 py2 ml1 mr3 myn3 xs-hide sm-hide'>
									<div>No posts found.</div>
								</div>
							</div>
						</div>
					</section>
				);
			}

			const post = posts.data[0];

			return (
				<section className='travel-discover py4 mb3 relative xs-hide sm-hide'>
					<div className='max-width-3 mx-auto'>
						<div className='flex justify-between items-center'>
							<header>
								<RichText
									key='editable'
									className='travel-discover-heading bold line-height-2 xs-hide sm-hide'
									tagName='h2'
									value={ heading }
									onChange={ ( value ) => setAttributes( { heading: value } ) }
									placeholder={ __( 'Discover Adventures' ) }
								/>
								<RichText
									key='editable'
									className='travel-discover-subheading h2 xs-hide sm-hide'
									tagName='div'
									value={ subheading }
									onChange={ ( value ) => setAttributes( { subheading: value } ) }
									placeholder={ __( 'Get inspired and find your next big trip' ) }
								/>
							</header>

							<div className='travel-discover-panel travel-shadow-hover px3 py2 ml1 myn3 xs-hide sm-hide'>
								<div className='bold h2 line-height-2 my1'>{ post.title.rendered }</div>
								<p className='travel-discover-panel-subheading h3 my1 line-height-2'>
									<RawHTML key='html'>{ decodeEntities( post.excerpt.rendered ) }</RawHTML>
								</p>
								<p className='my1'>
									<a className='travel-link' href={ post.link }>Read more</a>
								</p>
							</div>
						</div>
					</div>
				</section>
			);

		} ),
		save() {

			// Render in PHP.
			return null;
		}
	},
);
