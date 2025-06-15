# Password Strength Checker

This is a PHP-based web application that checks the strength of passwords based on several criteria and provides recommendations for improvement.

## Features

- Analyzes password strength based on:
  - Length (minimum 8 characters)
  - Presence of uppercase letters
  - Presence of lowercase letters
  - Presence of numbers
  - Presence of special characters
- Shows a visual strength meter with color-coded progress bar
- Provides detailed feedback and recommendations
- Displays password criteria with validation indicators
- Toggle password visibility

## Requirements

- PHP 7.0 or higher
- Web server (Apache, Nginx, or built-in PHP server)

## Installation

1. Clone the repository or create a new file named `index.php`
2. Copy the provided PHP/HTML code into the file
3. Place the file in your web server's document root
4. Access the application through your web browser

## Usage

1. Open the application in your web browser
2. Enter a password in the input field
3. Click the "Check Password Strength" button
4. View the strength analysis, progress bar, and recommendations

## Customization

You can customize the application by modifying:
- Color scheme in the CSS section
- Strength criteria in the `checkPasswordStrength()` function
- Visual elements in the HTML structure

## Security Note

This application runs entirely client-side after the initial page load. No passwords are stored or transmitted to any server beyond the initial form submission for analysis.

## License

This project is open-source and available under the MIT License.
```

## Features of the Password Strength Checker

1. **Password Analysis**:
   - Checks length (minimum 8 characters)
   - Verifies presence of uppercase letters
   - Verifies presence of lowercase letters
   - Checks for numbers
   - Checks for special characters

2. **Visual Feedback**:
   - Color-coded strength meter (red to green)
   - Strength level indicator (Very Weak to Excellent)
   - Password statistics (length and strength)

3. **Detailed Recommendations**:
   - Specific suggestions for improvement
   - Criteria checklist with validation indicators
   - Helpful tips for creating strong passwords

4. **User Experience**:
   - Toggle password visibility
   - Real-time length counter
   - Smooth animations
   - Responsive design for all devices
   - Clean, modern interface with gradient colors

To use this application, simply save the code as `index.php` and run it on any PHP-enabled web server. No database or additional setup is required.# Password-Strength-Checker
