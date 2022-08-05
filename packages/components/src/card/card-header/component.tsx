/**
 * Internal dependencies
 */
import { contextConnect, WordPressComponentProps } from '../../ui/context';
import { Flex } from '../../flex';
import { useCardHeader } from './hook';
import type { HeaderProps } from '../types';
/**
 * External dependencies
 */
import type { ForwardedRef } from 'react';

function UnconnectedCardHeader(
	props: WordPressComponentProps< HeaderProps, 'div' >,
	forwardedRef: ForwardedRef< any >
) {
	const headerProps = useCardHeader( props );

	return <Flex { ...headerProps } ref={ forwardedRef } />;
}

/**
 * `CardHeader` renders an optional header within a `Card`.
 *
 * @example
 * ```jsx
 * import { Card, CardBody, CardHeader } from `@wordpress/components`;
 *
 * <Card>
 * 	<CardHeader>...</CardHeader>
 * 	<CardBody>...</CardBody>
 * </Card>
 * ```
 */
export const CardHeader = contextConnect( UnconnectedCardHeader, 'CardHeader' );

export default CardHeader;
