// Chatbot API Service for IBMS Admin Assistant
// This service handles multilingual responses for admin assistance

export class ChatbotService {
  constructor() {
    this.responses = {
      // System Navigation Help
      navigation: {
        en: {
          dashboard: "The Dashboard shows your business overview with sales, orders, and key metrics. You can see today's performance and quick stats here.",
          users: "User Management lets you add, edit, and manage system users with different roles like Admin, Manager, Cashier, Storekeeper, and Customer.",
          products: "Product Management helps you add new products, update inventory, set prices, and organize items by categories.",
          orders: "Order Management shows all customer orders, their status, and payment information. You can process and track orders here.",
          sales: "Sales section displays all transactions, payment methods, and sales analytics to track your business performance.",
          customers: "Customer Management stores customer information, order history, and helps you build customer relationships.",
          reports: "Reports provide detailed analytics about sales, inventory, profits, and business insights with exportable data.",
          settings: "Settings allow you to configure system preferences, manage backups, and customize the application."
        },
        am: {
          dashboard: "ዳሽቦርዱ የንግድዎን አጠቃላይ እይታ ከሽያጭ፣ ትዕዛዞች እና ቁልፍ መለኪያዎች ጋር ያሳያል። የዛሬውን አፈጻጸም እና ፈጣን ስታቲስቲክስ እዚህ ማየት ይችላሉ።",
          users: "የተጠቃሚ አስተዳደር እንደ አስተዳዳሪ፣ ሥራ አስኪያጅ፣ ገንዘብ ተቀባይ፣ ማከማቻ ሠራተኛ እና ደንበኛ ያሉ የተለያዩ ሚናዎች ያላቸውን የስርዓት ተጠቃሚዎች እንዲጨምሩ፣ እንዲያርሙ እና እንዲያስተዳድሩ ያስችልዎታል።",
          products: "የምርት አስተዳደር አዳዲስ ምርቶችን እንዲጨምሩ፣ ኢንቬንቶሪ እንዲያዘምኑ፣ ዋጋዎችን እንዲያስቀምጡ እና እቃዎችን በምድቦች እንዲያደራጁ ይረዳዎታል።",
          orders: "የትዕዛዝ አስተዳደር ሁሉንም የደንበኛ ትዕዛዞች፣ ሁኔታቸውን እና የክፍያ መረጃዎችን ያሳያል። ትዕዛዞችን እዚህ ማስኬድ እና መከታተል ይችላሉ።",
          sales: "የሽያጭ ክፍል ሁሉንም ግብይቶች፣ የክፍያ ዘዴዎች እና የንግድዎን አፈጻጸም ለመከታተል የሽያጭ ትንታኔዎችን ያሳያል።",
          customers: "የደንበኛ አስተዳደር የደንበኛ መረጃዎችን፣ የትዕዛዝ ታሪክን ያከማቻል እና የደንበኛ ግንኙነቶችን እንዲገነቡ ይረዳዎታል።",
          reports: "ሪፖርቶች ስለ ሽያጭ፣ ኢንቬንቶሪ፣ ትርፍ እና ከሊቀ መረጃ ጋር የንግድ ግንዛቤዎች ዝርዝር ትንታኔዎችን ይሰጣሉ።",
          settings: "ቅንብሮች የስርዓት ምርጫዎችን እንዲያዋቅሩ፣ ምትኬዎችን እንዲያስተዳድሩ እና መተግበሪያውን እንዲያበጁ ያስችልዎታል።"
        },
        or: {
          dashboard: "Dashboard-n mul'ata waliigalaa daldalaa keessanii kan agarsiisu yoo ta'u, gurgurtaa, ajajawwan fi safartuu ijoo of keessaa qaba. Raawwii har'aa fi istaatiistiksii saffisaa asitti arguu dandeessu.",
          users: "Bulchiinsi Fayyadamtootaa fayyadamtoota sisteemii gahee adda addaa qaban kan akka Bulchaa, Hogganaa, Kaffaltuu, Kuusaa fi Maamila dabaluuf, gulaaluuf fi bulchuuf isin dandeessisa.",
          products: "Bulchiinsi Oomishaa oomishaalee haaraa dabaluuf, inventarii haaromsuuf, gatii kaa'uuf fi meeshaalee ramaddii keessatti qindeessuuf isin gargaara.",
          orders: "Bulchiinsi Ajajaa ajajawwan maamilaa hunda, haala isaanii fi odeeffannoo kaffaltii agarsiisa. Ajajawwan asitti adeemsisuu fi hordofuu dandeessu.",
          sales: "Kutaan Gurgurtaa daldalaa hunda, malawwan kaffaltii fi xiinxala gurgurtaa raawwii daldalaa keessanii hordofuuf agarsiisa.",
          customers: "Bulchiinsi Maamilaa odeeffannoo maamilaa, seenaa ajajaa kuusa fi hariiroo maamilaa ijaaruuf isin gargaara.",
          reports: "Gabaasoti waa'ee gurgurtaa, inventarii, bu'aa fi hubannoo daldalaa daataa ergamuu danda'u waliin xiinxala bal'inaan kennu.",
          settings: "Qindaa'inni filannoo sisteemii qindeessuuf, backup bulchuuf fi aplikeeshinii haala barbaadamuun qindeessuuf isin dandeessisa."
        }
      },

      // Feature-specific help
      features: {
        en: {
          addUser: "To add a new user: 1) Click 'Add User' button, 2) Fill in name and email, 3) Select appropriate role, 4) Set password, 5) Click 'Create User'.",
          editUser: "To edit a user: 1) Find the user in the list, 2) Click 'Edit' button, 3) Update information, 4) Click 'Update User'.",
          deleteUser: "To delete a user: 1) Find the user in the list, 2) Click delete button (🗑️), 3) Confirm deletion. Note: You cannot delete your own account.",
          addProduct: "To add a product: 1) Go to Products page, 2) Click 'Add Product', 3) Enter product details, 4) Set price and stock, 5) Save product.",
          generateReport: "To generate reports: 1) Go to Reports page, 2) Select date range, 3) Choose report type, 4) Click 'Generate Report', 5) Export if needed.",
          processOrder: "To process an order: 1) Go to Orders page, 2) Find the order, 3) Update status, 4) Process payment if needed, 5) Save changes."
        },
        am: {
          addUser: "አዲስ ተጠቃሚ ለመጨመር፡ 1) 'ተጠቃሚ ጨምር' አዝራርን ይጫኑ፣ 2) ስም እና ኢሜይል ይሙሉ፣ 3) ተገቢውን ሚና ይምረጡ፣ 4) የይለፍ ቃል ያስቀምጡ፣ 5) 'ተጠቃሚ ፍጠር'ን ይጫኑ።",
          editUser: "ተጠቃሚን ለማርትዕ፡ 1) ተጠቃሚውን በዝርዝሩ ውስጥ ያግኙ፣ 2) 'አርትዕ' አዝራርን ይጫኑ፣ 3) መረጃውን ያዘምኑ፣ 4) 'ተጠቃሚ አዘምን'ን ይጫኑ።",
          deleteUser: "ተጠቃሚን ለመሰረዝ፡ 1) ተጠቃሚውን በዝርዝሩ ውስጥ ያግኙ፣ 2) የመሰረዝ አዝራርን (🗑️) ይጫኑ፣ 3) መሰረዝን ያረጋግጡ። ማስታወሻ፡ የራስዎን መለያ መሰረዝ አይችሉም።",
          addProduct: "ምርት ለመጨመር፡ 1) ወደ ምርቶች ገጽ ይሂዱ፣ 2) 'ምርት ጨምር'ን ይጫኑ፣ 3) የምርት ዝርዝሮችን ያስገቡ፣ 4) ዋጋ እና ክምችት ያስቀምጡ፣ 5) ምርቱን ያስቀምጡ።",
          generateReport: "ሪፖርቶችን ለማመንጨት፡ 1) ወደ ሪፖርቶች ገጽ ይሂዱ፣ 2) የቀን ክልል ይምረጡ፣ 3) የሪፖርት አይነት ይምረጡ፣ 4) 'ሪፖርት አመንጭ'ን ይጫኑ፣ 5) ከፈለጉ ይላኩ።",
          processOrder: "ትዕዛዝ ለማስኬድ፡ 1) ወደ ትዕዛዞች ገጽ ይሂዱ፣ 2) ትዕዛዙን ያግኙ፣ 3) ሁኔታውን ያዘምኑ፣ 4) ከፈለጉ ክፍያ ያስኬዱ፣ 5) ለውጦችን ያስቀምጡ።"
        },
        or: {
          addUser: "Fayyadamaa haaraa dabaluuf: 1) Balaasii 'Fayyadamaa Dabaluu' cuqaasaa, 2) Maqaa fi imeelii guutaa, 3) Gahee mijaa'aa filaa, 4) Jecha icciitii kaa'aa, 5) 'Fayyadamaa Uumuu' cuqaasaa.",
          editUser: "Fayyadamaa gulaaluuf: 1) Fayyadamaa tarree keessatti argaa, 2) Balaasii 'Gulaaluu' cuqaasaa, 3) Odeeffannoo haaromsaa, 4) 'Fayyadamaa Haaromsuu' cuqaasaa.",
          deleteUser: "Fayyadamaa haquuf: 1) Fayyadamaa tarree keessatti argaa, 2) Balaasii haquu (🗑️) cuqaasaa, 3) Haquu mirkaneessaa. Yaadannoo: Akkaawuntii mataa keessanii haquu hin dandeessan.",
          addProduct: "Oomishaa dabaluuf: 1) Gara fuula Oomishaaleetti deemaa, 2) 'Oomishaa Dabaluu' cuqaasaa, 3) Bal'ina oomishaa galchaa, 4) Gatii fi kuusaa kaa'aa, 5) Oomishaa olkaa'aa.",
          generateReport: "Gabaasota maddisiisuuf: 1) Gara fuula Gabaasotaatti deemaa, 2) Hangii guyyaa filaa, 3) Gosa gabaasaa filaa, 4) 'Gabaasa Maddisiisuu' cuqaasaa, 5) Yoo barbaaddan ergaa.",
          processOrder: "Ajaja adeemsiisuuf: 1) Gara fuula Ajajaatti deemaa, 2) Ajaja argaa, 3) Haala haaromsaa, 4) Yoo barbaaddan kaffaltii adeemsisaa, 5) Jijjiirama olkaa'aa."
        }
      },

      // Common greetings and responses
      greetings: {
        en: [
          "Hello! I'm your IBMS assistant. How can I help you manage your business today?",
          "Hi there! I'm here to help you with any questions about the system.",
          "Welcome! I can assist you with navigation, user management, reports, and more.",
          "Good day! What would you like to know about the IBMS system?"
        ],
        am: [
          "ሰላም! እኔ የIBMS ረዳትዎ ነኝ። ዛሬ ንግድዎን ለማስተዳደር እንዴት ልረዳዎት እችላለሁ?",
          "ሰላም! ስለ ስርዓቱ ማንኛውም ጥያቄ ለመመለስ እዚህ ነኝ።",
          "እንኳን በደህና መጡ! በአሰሳ፣ በተጠቃሚ አስተዳደር፣ በሪፖርቶች እና በሌሎችም ልረዳዎት እችላለሁ።",
          "መልካም ቀን! ስለ IBMS ስርዓት ምን ማወቅ ይፈልጋሉ?"
        ],
        or: [
          "Nagaa! Ani gargaaraa IBMS keessan. Har'a daldalaa keessan bulchuuf akkamitti isin gargaaruu danda'a?",
          "Nagaa! Waa'ee sisteemichaa gaaffii kamiyyuu deebisuuf asitti argama.",
          "Baga nagaan dhuftan! Navigeeshinii, bulchiinsa fayyadamtootaa, gabaasotaa fi kan biraatiin isin gargaaruu nan danda'a.",
          "Guyyaa gaarii! Waa'ee sisteemii IBMS maal beekuu barbaaddu?"
        ]
      }
    }
  }

  // Get response based on message and language
  getResponse(message, language = 'en') {
    const lowerMessage = message.toLowerCase()
    
    // Check for greetings
    if (this.isGreeting(lowerMessage)) {
      return this.getRandomGreeting(language)
    }
    
    // Check for navigation help
    if (lowerMessage.includes('navigate') || lowerMessage.includes('አሰሳ') || lowerMessage.includes('navigeesh')) {
      return this.getNavigationHelp(lowerMessage, language)
    }
    
    // Check for feature-specific help
    if (lowerMessage.includes('add user') || lowerMessage.includes('ተጠቃሚ ጨምር') || lowerMessage.includes('fayyadamaa dabal')) {
      return this.responses.features[language].addUser
    }
    
    if (lowerMessage.includes('edit user') || lowerMessage.includes('ተጠቃሚ አርትዕ') || lowerMessage.includes('fayyadamaa gulaal')) {
      return this.responses.features[language].editUser
    }
    
    if (lowerMessage.includes('delete user') || lowerMessage.includes('ተጠቃሚ ሰርዝ') || lowerMessage.includes('fayyadamaa haqi')) {
      return this.responses.features[language].deleteUser
    }
    
    if (lowerMessage.includes('add product') || lowerMessage.includes('ምርት ጨምር') || lowerMessage.includes('oomishaa dabal')) {
      return this.responses.features[language].addProduct
    }
    
    if (lowerMessage.includes('report') || lowerMessage.includes('ሪፖርት') || lowerMessage.includes('gabaasa')) {
      return this.responses.features[language].generateReport
    }
    
    if (lowerMessage.includes('order') || lowerMessage.includes('ትዕዛዝ') || lowerMessage.includes('ajaja')) {
      return this.responses.features[language].processOrder
    }
    
    // Default response
    return this.getDefaultResponse(language)
  }

  isGreeting(message) {
    const greetingWords = ['hello', 'hi', 'hey', 'ሰላም', 'nagaa', 'good morning', 'good day']
    return greetingWords.some(word => message.includes(word))
  }

  getRandomGreeting(language) {
    const greetings = this.responses.greetings[language]
    return greetings[Math.floor(Math.random() * greetings.length)]
  }

  getNavigationHelp(message, language) {
    // Check which specific page they're asking about
    if (message.includes('dashboard') || message.includes('ዳሽቦርድ')) {
      return this.responses.navigation[language].dashboard
    }
    if (message.includes('user') || message.includes('ተጠቃሚ') || message.includes('fayyadam')) {
      return this.responses.navigation[language].users
    }
    if (message.includes('product') || message.includes('ምርት') || message.includes('oomisha')) {
      return this.responses.navigation[language].products
    }
    if (message.includes('order') || message.includes('ትዕዛዝ') || message.includes('ajaja')) {
      return this.responses.navigation[language].orders
    }
    if (message.includes('sale') || message.includes('ሽያጭ') || message.includes('gurgur')) {
      return this.responses.navigation[language].sales
    }
    if (message.includes('customer') || message.includes('ደንበኛ') || message.includes('maamil')) {
      return this.responses.navigation[language].customers
    }
    if (message.includes('report') || message.includes('ሪፖርት') || message.includes('gabaasa')) {
      return this.responses.navigation[language].reports
    }
    if (message.includes('setting') || message.includes('ቅንብር') || message.includes('qindaa')) {
      return this.responses.navigation[language].settings
    }
    
    // General navigation help
    const generalNav = {
      en: "I can help you navigate to any section: Dashboard, Users, Products, Orders, Sales, Customers, Reports, or Settings. Which section would you like to visit?",
      am: "ወደ ማንኛውም ክፍል እንዲሄዱ ልረዳዎት እችላለሁ፡ ዳሽቦርድ፣ ተጠቃሚዎች፣ ምርቶች፣ ትዕዛዞች፣ ሽያጭ፣ ደንበኞች፣ ሪፖርቶች ወይም ቅንብሮች። የትኛውን ክፍል መጎብኘት ይፈልጋሉ?",
      or: "Kutaa kamiyyuuttis akka deemtan isin gargaaruu nan danda'a: Dashboard, Fayyadamtoota, Oomishaalee, Ajajawwan, Gurgurtaa, Maamiloota, Gabaasota ykn Qindaa'ina. Kutaa kam daawwachuu barbaaddu?"
    }
    return generalNav[language]
  }

  getDefaultResponse(language) {
    const defaults = {
      en: "I'm here to help you with the IBMS system! You can ask me about:\n• Navigation and finding features\n• User management\n• Product management\n• Order processing\n• Reports and analytics\n• System settings\n\nWhat would you like to know?",
      am: "የIBMS ስርዓት ለመርዳት እዚህ ነኝ! ስለሚከተሉት መጠየቅ ይችላሉ፡\n• አሰሳ እና ባህሪያትን ማግኘት\n• የተጠቃሚ አስተዳደር\n• የምርት አስተዳደር\n• የትዕዛዝ ማስኬድ\n• ሪፖርቶች እና ትንታኔዎች\n• የስርዓት ቅንብሮች\n\nምን ማወቅ ይፈልጋሉ?",
      or: "Sisteemii IBMS gargaaruuf asitti argama! Waa'ee kanneen armaan gadii gaafachuu dandeessu:\n• Navigeeshinii fi amaloota argachuu\n• Bulchiinsa fayyadamtootaa\n• Bulchiinsa oomishaa\n• Adeemsisa ajajaa\n• Gabaasotaa fi xiinxala\n• Qindaa'ina sisteemii\n\nMaal beekuu barbaaddu?"
    }
    return defaults[language]
  }
}

// Export singleton instance
export const chatbotService = new ChatbotService()