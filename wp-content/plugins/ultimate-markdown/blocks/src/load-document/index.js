const {registerPlugin} = wp.plugins;
import render from './components/Sidebar';

registerPlugin(
    'daextulma-load-document',
    {
      icon: false,
      render,
    },
);