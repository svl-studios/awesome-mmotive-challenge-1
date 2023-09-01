import { registerBlockType } from '@wordpress/blocks';
import './style.scss';
import editTable from './edit';
import save from './save';
import metadata from './block.json';

registerBlockType(
	metadata.name, {
		edit: editTable, save,
	}
);
