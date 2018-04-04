// jscs:disable disallowMultipleLineStrings
// jscs:disable validateQuoteMarks

/**
 * Internal block libraries.
 */
const { __ } = wp.i18n;
const { registerBlockType, RichText } = wp.blocks;
const { Placeholder, withAPIData } = wp.components;
const { RawHTML } = wp.element;
const { decodeEntities } = wp.utils;

/**
 * Register block.
 */
export default registerBlockType(
	'amp-travel/activity-list',
	{
		title: __( 'Activity list' ),
		category: 'common',
		icon: 'wordpress-alt',
		keywords: [
			__( 'Browse activities' ),
			__( 'Travel' )
		],

		attributes: {
			heading: {
				source: 'children',
				type: 'array',
				selector: '.travel-activities h3'
			}
		},

		edit: withAPIData( () => {
			return {
				activityResults: '/wp/v2/activities'
			};
		} )( ( { activityResults, attributes, setAttributes } ) => {
			const hasActivities = Array.isArray( activityResults.data ) && activityResults.data.length;
			if ( ! hasActivities ) {
				return (
					<Placeholder key="placeholder"
					             icon="admin-post"
					             label={ __( 'Activities' ) }
					>
						{ __( 'No activities found, add some to use the block.' ) }
					</Placeholder>
				);
			}

			const activities = activityResults.data;
			const { heading } = attributes;

			return (
				<section className='travel-activities pb4 pt3 relative'>
					<div className='max-width-3 mx-auto px1 md-px2'>
						<RichText
							key='editable'
							className='bold h1 line-height-2'
							tagName='h3'
							value={ heading }
							onChange={ ( value ) => setAttributes( { heading: value } ) }
							placeholder={ __( 'Browse by activity' ) }
						/>
					</div>
					<div className='overflow-scroll'>
						<div className='travel-overflow-container'>
							<div className='flex p1 md-px1 mxn1'>
								{ activities.map( ( activity, i ) =>
									<a href={ activity.link } className='travel-activities-activity travel-type-active mx1' target="_blank">
										<div className='travel-shadow circle inline-block'>
											<div className='travel-activities-activity-icon'>
												<RawHTML key='html'>{ decodeEntities( activity.svg ) }</RawHTML>
												<RawHTML key='html'>{ decodeEntities( activity.meta.amp_travel_activity_svg ) }</RawHTML>
											</div>
										</div>
										<p className='bold center line-height-4'>
											{ activity.name }
										</p>
									</a>
								) }
							</div>
						</div>
					</div>
				</section>
			);
		} ),
		save() {

			// Handled in PHP.
			return null;
		}
	},
);
