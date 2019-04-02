/* eslint-disable space-in-parens */

/**
 * Internal block libraries.
 */
const { registerBlockType } = wp.blocks;
const { TextControl, PanelBody, ServerSideRender } = wp.components;
const { InspectorControls } = wp.editor;
const { Fragment } = wp.element;
const { __ } = wp.i18n;


const blockName = 'amp-travel/discover';

/**
 * Register block.
 */
export default registerBlockType(
	blockName,
	{
		title: __( 'Discover block' ),
		category: 'common',
		icon: 'palmtree',
		keywords: [
			__( 'Adventures', 'travel' ),
			__( 'Travel', 'travel' )
		],

		edit: ( { isSelected, setAttributes, attributes } ) => {
			const { heading, subheading } = attributes;

			return [
				isSelected && (
					<InspectorControls key="discover-inspector">
						<PanelBody title={ __( 'Discover block settings', 'travel' ) }>
							<TextControl
								label={ __( 'Discover Header', 'travel' ) }
								value={ heading }
								onChange={ ( value ) => {
									setAttributes( { heading: value } );
								} }
							/>
							<TextControl
								label={ __( 'Discover Sub-heading', 'travel' ) }
								value={ subheading }
								onChange={ ( value ) => {
									setAttributes( { subheading: value } );
								} }
							/>
						</PanelBody>
					</InspectorControls>
				),

				<Fragment key="discover-ssr">
					<ServerSideRender
						block={ blockName }
						attributes={ attributes }
					/>
				</Fragment>
			];
		},

		save: () => {

			// Render in PHP.
			return null;
		}
	}
);
