/**
 * Internal block libraries.
 */
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

/**
 * Register block.
 */
export default registerBlockType(
	'amp-travel/travel-angles',
	{
		title: __( 'Travel Angles' ),
		category: 'common',
		icon: 'wordpress-alt',
		keywords: [
			__( 'Design' ),
		],

		// Copy from Travel HTML template.
		edit: props => {
			return (
				<div className="travel-angles max-width-3 mx-auto">
					<div className="travel-angle-left">
						<div className="travel-angle-1 absolute"></div>
					</div>
					<div className="travel-angle-left">
						<div className="travel-angle-2 absolute"></div>
					</div>
					<div className="travel-angle-right">
						<div className="travel-angle-3 absolute"></div>
					</div>
				</div>
			);
		},
		save: props => {
			return (
				<div className="travel-angles max-width-3 mx-auto">
					<div className="travel-angle-left">
						<div className="travel-angle-1 absolute"></div>
					</div>
					<div className="travel-angle-left">
						<div className="travel-angle-2 absolute"></div>
					</div>
					<div className="travel-angle-right">
						<div className="travel-angle-3 absolute"></div>
					</div>
				</div>
			);
		},
	},
);
