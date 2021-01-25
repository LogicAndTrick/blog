// styles
import 'vitepress/dist/client/theme-default/styles/vars.css';
import './styles/vars.css';
import 'vitepress/dist/client/theme-default/styles/layout.css';
import 'vitepress/dist/client/theme-default/styles/code.css';
import 'vitepress/dist/client/theme-default/styles/custom-blocks.css';
import 'vitepress/dist/client/theme-default/styles/sidebar-links.css';
import './styles/custom.css';

// layouts
import Layout from './Layout.vue';
import NotFound from 'vitepress/dist/client/theme-default/NotFound.vue';

const theme = {
    Layout,
    NotFound
};
export default theme;
