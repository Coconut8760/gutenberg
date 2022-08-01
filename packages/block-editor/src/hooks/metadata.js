/**
 * External dependencies
 */
import { has } from 'lodash';

/**
 * WordPress dependencies
 */
import { addFilter } from '@wordpress/hooks';
import { hasBlockMetadataSupport } from '@wordpress/blocks';

/**
 * Filters registered block settings, extending attributes to include `metadata`.
 *
 * see: https://github.com/WordPress/gutenberg/pull/40393/files#r864632012
 *
 * @param {Object} blockTypeSettings Original block settings.
 * @return {Object} Filtered block settings.
 */
export function addMetaAttribute( blockTypeSettings ) {
	// Allow blocks to specify their own attribute definition with default values if needed.
	if (
		has( blockTypeSettings.attributes, [
			'__experimentalMetadata',
			'type',
		] )
	) {
		return blockTypeSettings;
	}
	if ( hasBlockMetadataSupport( blockTypeSettings ) ) {
		blockTypeSettings.attributes = {
			...blockTypeSettings.attributes,
			__experimentalMetadata: {
				type: 'object',
			},
		};
	}

	return blockTypeSettings;
}

export function addSaveProps( extraProps, blockType, attributes ) {
	if ( hasBlockMetadataSupport( blockType ) ) {
		extraProps.__experimentalMetadata = attributes.__experimentalMetadata;
	}

	return extraProps;
}

addFilter(
	'blocks.registerBlockType',
	'core/metadata/addMetaAttribute',
	addMetaAttribute
);

addFilter(
	'blocks.getSaveContent.extraProps',
	'core/metadata/save-props',
	addSaveProps
);
