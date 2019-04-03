/* eslint-disable space-in-parens */

/**
 * Internal block libraries.
 */
const { registerBlockType } = wp.blocks;
const { InspectorControls } = wp.editor;
const { ServerSideRender, TextControl, PanelBody } = wp.components;
const { Fragment } = wp.element;
const { __ } = wp.i18n;

const blockName = 'amp-travel/activity-list';

/**
 * Register block.
 */
export default registerBlockType(
	blockName,
	{
		title: __( 'Activity list', 'travel' ),
		category: 'common',
		icon: 'tickets',
		keywords: [
			__( 'Browse activities', 'travel' ),
			__( 'Travel', 'travel' )
		],

		edit( { attributes, isSelected, setAttributes } ) {
			const { heading } = attributes;

			return [
				isSelected && (
					<InspectorControls key="activity-inspector">
						<PanelBody title={ __( 'Activity List settings', 'travel' ) }>
							<TextControl
								label={ __( 'Activity List Header', 'travel' ) }
								value={ heading }
								onChange={ ( value ) => setAttributes( { heading: value } ) }
							/>
						</PanelBody>
					</InspectorControls>
				),

				<Fragment key="activity-ssr">
					<ServerSideRender
						block={ blockName }
						attributes={ attributes }
					/>
				</Fragment>
			];
		},

		save() {

			// Handled in PHP.
			return null;
		}
	}
);
