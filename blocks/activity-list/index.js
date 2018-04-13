// jscs:disable disallowMultipleLineStrings
// jscs:disable validateQuoteMarks
/* eslint-disable space-in-parens */

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

		edit: withAPIData( () => {
			return {
				activityResults: '/wp/v2/activities'
			};
		} )( ( { activityResults } ) => {
			const hasActivities = Array.isArray( activityResults.data ) && activityResults.data.length;
			if ( ! hasActivities ) {
				return (
					<Placeholder key="placeholder" icon="admin-post" label={ __( 'Activities' ) }
					>
						{ __( 'No activities found, add some to use the block.' ) }
					</Placeholder>
				);
			}

			const activities = activityResults.data;

			return (
				<section className='travel-activities pb4 pt3 relative'>
					<div className='max-width-3 mx-auto px1 md-px2'>
						<h3 className='bold h1 line-height-2'>{ __( 'Browse by activity' ) }</h3>
					</div>
					<div className='overflow-scroll'>
						<div className='travel-overflow-container'>
							<div className='flex p1 md-px1 mxn1'>
								{ activities.map( ( activity, i ) =>
									<a key='activity' href={ activity.link } className={ 'travel-activities-activity mx1 travel-type-' + activity.slug } target="_blank">
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
	}
);
