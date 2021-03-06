import { Component, Mixin, Application } from 'src/core/shopware';
import template from './sw-login.html.twig';
import './sw-login.less';

Component.register('sw-login', {
    template,

    mixins: [
        Mixin.getByName('notification')
    ],

    data() {
        return {
            isLoading: false,
            isLoginSuccess: false,
            isLoginError: false
        };
    },

    computed: {
        username: {
            get() {
                return this.$store.state.login.username;
            },
            set(value) {
                this.$store.commit('login/setUserName', value);
            }
        },
        password: {
            get() {
                return this.$store.state.login.password;
            },
            set(value) {
                this.$store.commit('login/setUserPassword', value);
            }
        },
        errorTitle() {
            return this.$store.state.login.errorTitle;
        },
        errorMessage() {
            return this.$store.state.login.errorMessage;
        }
    },

    methods: {
        loginUserWithPassword() {
            this.isLoading = true;

            return this.$store.dispatch('login/loginUserWithPassword').then((success) => {
                this.isLoading = false;

                if (success === true) {
                    this.handleLoginSuccess();
                } else {
                    this.handleLoginError();
                }
            });
        },

        handleLoginSuccess() {
            this.isLoginSuccess = true;

            setTimeout(() => {
                this.isLoginSuccess = false;
                this.forwardLogin();
            }, 300);
        },

        handleLoginError() {
            this.isLoginError = true;

            setTimeout(() => {
                this.isLoginError = false;
            }, 500);

            this.createNotificationError({
                title: this.$store.state.login.errorTitle,
                message: this.$store.state.login.errorMessage
            });
        },

        forwardLogin() {
            const initContainer = Application.getContainer('init');
            const routerFactory = initContainer.router;
            const previousRoute = routerFactory.getPreviousRoute();

            if (!this.$store.state.login.token.length ||
                this.$store.state.login.expiry === -1) {
                return;
            }

            if (this.$route.query.redirectToPreviousUrl && previousRoute.name) {
                this.$router.push(previousRoute.fullPath);
                return;
            }

            this.$router.push({
                name: 'core'
            });
        }
    }
});
