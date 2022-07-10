wp.blocks.registerBlockType(
	'rpssrb/random-posts',
	{
		title: 'Random Posts',
		edit: function () {
			return wp.element.createElement(
				wp.serverSideRender,
				{
					block: 'rpssrb/random-posts'
				}
			);
		}
	}
);