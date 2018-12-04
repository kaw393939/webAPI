import Vue from 'vue';
import editProfile from 'editProfile.vue'

describe('editProfile', () => {
    // check for submit function
    it('has a form submission function', () => {
        expect(typeof editProfile.submit).toBe('function')
    })
})

