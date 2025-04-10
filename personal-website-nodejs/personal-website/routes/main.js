const express = require('express');
const router = express.Router();
const mainController = require('../controllers/mainController');

// Define routes
router.get('/', mainController.getHomePage);
router.get('/about', mainController.getAboutPage);
router.get('/contact', mainController.getContactPage);
router.post('/contact', mainController.postContactForm);

module.exports = router;
