
import { useUserStore } from '../store/user';

const beforeEach = async (to, from, next) => {
    const userStore = useUserStore();
    const { authenticated, user } = userStore;

    document.title = `Todo App: ${to.meta.title}`;

    if (to.meta.middleware === 'guest') {
        next();
    } else {
        if (!authenticated) {
            next({ name: 'login' });
            return;
        }

        next();
    }
};

export default beforeEach;
